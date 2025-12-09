/**
 * Checkout Coupon Handler
 * Handles coupon application and removal on the checkout page
 * 
 * Features:
 * - AJAX coupon validation
 * - Dynamic total updates
 * - Success/error message display
 * - Coupon field disable/enable
 * - Remove coupon functionality
 */

(function(root) {
    'use strict';

    // ============================================
    // Configuration
    // ============================================
    var ENDPOINT_APPLY = '/api/validate-coupon';
    var ENDPOINT_REMOVE = '/api/remove-coupon';

    // Get CSRF token from meta tag or form input
    var csrfToken = (function() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        if (meta) return meta.content;
        
        var tokenInput = document.querySelector('input[name="_token"]');
        if (tokenInput) return tokenInput.value;
        
        return root.csrfToken || '';
    })();

    // ============================================
    // DOM Element Cache
    // ============================================
    var el = {};

    // Function to refresh DOM element cache
    function refreshElements() {
        el = {
            input: document.getElementById('coupon_code'),
            message: document.getElementById('coupon_message'),
            applyBtn: document.getElementById('apply_coupon_btn'),
            removeBtn: document.getElementById('remove_coupon_btn'),
            discountRow: document.getElementById('coupon_discount_row'),
            codeDisplay: document.getElementById('coupon_code_display'),
            discountAmount: document.getElementById('coupon_discount_amount'),
            grandTotal: document.getElementById('grand_total'),
            subtotal: document.getElementById('subtotal'),
            hiddenField: document.getElementById('coupon_code_input')
        };
        
        // Debug: Log if elements are found
        if (!el.applyBtn) {
            console.warn('CheckoutCoupon: apply_coupon_btn not found');
        }
        if (!el.input) {
            console.warn('CheckoutCoupon: coupon_code input not found');
        }
        
        return el;
    }

    // Initial element cache
    refreshElements();

    // ============================================
    // State Management
    // ============================================
    var state = {
        applying: false,
        originalGrandTotal: null,
        currentCode: null,
        currentDiscount: 0,
        abortController: null,
        delegationBound: false,
        applyBtnOriginalHtml: null
    };

    // Initialize original grand total from the page
    function initializeOriginalTotal() {
        if (el.grandTotal) {
            var text = el.grandTotal.textContent.trim();
            var num = parseFloat(text.replace(/[^0-9.]/g, ''));
            // Always round up the final payable amount (e.g., 245.05 → 246)
            state.originalGrandTotal = isNaN(num) ? null : Math.ceil(num);
        }
        
        // Fallback to window variable if available
        if (!state.originalGrandTotal && root.originalGrandTotal) {
            // Always round up the final payable amount
            state.originalGrandTotal = Math.ceil(Number(root.originalGrandTotal));
        }
    }

    // ============================================
    // Utility Functions
    // ============================================
    function escapeHtml(str) {
        if (!str) return '';
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return String(str).replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    function formatCurrency(amount) {
        if (amount === null || amount === undefined || isNaN(Number(amount))) return '';
        return Number(amount).toFixed(2);
    }

    function setTextPreservingSymbol(node, value) {
        if (!node) return;
        var original = node.textContent || '';
        var trimmed = original.trim();
        var prefixMatch = trimmed.match(/^[^\d\-+.,]*/);
        var suffixMatch = trimmed.match(/[^0-9.,\s]*$/);
        var prefix = (prefixMatch && prefixMatch[0]) || '';
        var suffix = (suffixMatch && suffixMatch[0]) || '';
        // Always round up the final payable amount (e.g., 245.05 → 246)
        var roundedValue = Math.ceil(Number(value));
        node.textContent = prefix + roundedValue + suffix;
    }

    // ============================================
    // Message Display
    // ============================================
    function showMessage(type, text) {
        if (!el.message) return;
        
        if (!text) {
            el.message.innerHTML = '';
            el.message.className = '';
            return;
        }

        var classes = {
            'success': 'text-success',
            'error': 'text-danger',
            'warning': 'text-warning',
            'info': 'text-info'
        };

        var id = 'msg-' + Date.now();
        el.message.dataset.msgId = id;
        el.message.className = classes[type] || 'text-info';
        el.message.innerHTML = '<span>' + escapeHtml(text) + '</span>';
        
        // Auto-hide success messages after 5 seconds
        if (type === 'success') {
            setTimeout(function() {
                if (el.message && el.message.dataset && el.message.dataset.msgId === id) {
                    el.message.innerHTML = '';
                    el.message.className = '';
                    delete el.message.dataset.msgId;
                }
            }, 5000);
        }
    }

    function clearMessage() {
        showMessage('', '');
    }

    // ============================================
    // HTTP Request Handler
    // ============================================
    function postJSON(url, data) {
        // Cancel any pending request
        if (state.abortController) {
            state.abortController.abort();
        }

        // Use Fetch API if available
        if (root.fetch) {
            state.abortController = new AbortController();
            
            return fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(data || {}),
                signal: state.abortController.signal
            })
            .then(function(response) {
                var ct = response.headers.get('content-type') || '';
                if (ct.indexOf('application/json') !== -1) {
                    return response.json().then(function(json) {
                        return {
                            ok: response.ok,
                            status: response.status,
                            body: json
                        };
                    });
                } else {
                    return response.text().then(function(text) {
                        return {
                            ok: response.ok,
                            status: response.status,
                            body: { message: text }
                        };
                    });
                }
            })
            .catch(function(error) {
                if (error.name === 'AbortError') {
                    return { ok: false, status: 0, body: { message: 'Request cancelled' } };
                }
                throw error;
            });
        }

        // Fallback to jQuery if available
        if (root.jQuery) {
            return new Promise(function(resolve) {
                root.jQuery.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    contentType: 'application/json',
                    data: JSON.stringify(data || {}),
                    dataType: 'json'
                })
                .done(function(resp, textStatus, xhr) {
                    resolve({
                        ok: true,
                        status: xhr.status,
                        body: resp
                    });
                })
                .fail(function(xhr) {
                    var body = xhr.responseJSON || { message: 'Request failed' };
                    resolve({
                        ok: false,
                        status: xhr.status || 500,
                        body: body
                    });
                });
            });
        }

        // No HTTP library available
        return Promise.reject(new Error('No HTTP library available (fetch or jQuery required)'));
    }

    // ============================================
    // UI State Management
    // ============================================
    function setApplying(isApplying) {
        state.applying = isApplying;
        
        if (el.applyBtn) {
            if (!state.applyBtnOriginalHtml) {
                state.applyBtnOriginalHtml = el.applyBtn.innerHTML;
            }
            el.applyBtn.disabled = isApplying;
            if (isApplying) {
                el.applyBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Applying...';
            } else {
                el.applyBtn.innerHTML = state.applyBtnOriginalHtml || 'Apply Coupon';
            }
        }
    }

    function updateTotals(discountAmount, newTotal) {
        // Update discount row
        if (el.discountAmount) {
            el.discountAmount.textContent = formatCurrency(discountAmount);
        }
        
        if (el.discountRow) {
            var shouldShow = discountAmount > 0;
            if (el.discountRow.classList) {
                el.discountRow.classList.toggle('d-none', !shouldShow);
            } else {
                el.discountRow.style.display = shouldShow ? '' : 'none';
            }
        }

        // Update grand total
        if (el.grandTotal && newTotal !== undefined) {
            setTextPreservingSymbol(el.grandTotal, Number(newTotal));
        }
    }

    function enableCouponField() {
        if (el.input) {
            el.input.readOnly = false;
            el.input.value = '';
            el.input.focus();
        }
        if (el.applyBtn) {
            el.applyBtn.style.display = 'inline-block';
        }
        if (el.removeBtn) {
            el.removeBtn.style.display = 'none';
        }
    }

    function disableCouponField() {
        if (el.input) {
            el.input.readOnly = true;
        }
        if (el.applyBtn) {
            el.applyBtn.style.display = 'none';
        }
        if (el.removeBtn) {
            el.removeBtn.style.display = 'inline-block';
        }
    }

    function resetUI() {
        state.currentCode = null;
        state.currentDiscount = 0;
        
        enableCouponField();
        updateTotals(0, state.originalGrandTotal);
        
        if (el.codeDisplay) {
            el.codeDisplay.textContent = '';
        }
        
        if (el.hiddenField) {
            el.hiddenField.value = '';
        }
    }

    // ============================================
    // Coupon Application
    // ============================================
    function applyCoupon(e) {
        console.log('=== applyCoupon FUNCTION CALLED ===', e);
        
        if (e && e.preventDefault) {
            e.preventDefault();
        }

        // Refresh elements in case they weren't available before
        refreshElements();
        
        console.log('CheckoutCoupon: Elements after refresh:', {
            input: !!el.input,
            applyBtn: !!el.applyBtn,
            message: !!el.message
        });

        console.log('CheckoutCoupon: Apply button clicked');

        // Prevent multiple simultaneous requests
        if (state.applying) {
            console.log('CheckoutCoupon: Already applying, ignoring');
            return false;
        }

        // Get and validate coupon code
        var code = el.input ? el.input.value.trim().toUpperCase() : '';
        console.log('CheckoutCoupon: Coupon code entered:', code);
        
        if (!code) {
            console.log('CheckoutCoupon: No coupon code entered');
            showMessage('error', 'Please enter a coupon code');
            if (el.input) el.input.focus();
            return false;
        }

        // Clear previous messages
        clearMessage();
        setApplying(true);
        console.log('CheckoutCoupon: Sending validation request for:', code);
        console.log('CheckoutCoupon: Endpoint:', ENDPOINT_APPLY);

        // Send validation request
        console.log('CheckoutCoupon: About to call postJSON with:', {
            url: ENDPOINT_APPLY,
            code: code,
            csrfToken: csrfToken ? 'present' : 'missing'
        });
        
        postJSON(ENDPOINT_APPLY, { code: code })
            .then(function(response) {
                console.log('CheckoutCoupon: Response received:', response);
                console.log('CheckoutCoupon: Response status:', response.status);
                console.log('CheckoutCoupon: Response ok:', response.ok);
                var body = response.body || {};
                console.log('CheckoutCoupon: Response body:', body);
                
                if (response.ok && body.success) {
                    console.log('CheckoutCoupon: Coupon applied successfully');
                    // Success: Coupon applied
                    state.currentCode = code;
                    state.currentDiscount = parseFloat(body.discount_amount || 0);
                    
                    // Refresh elements before updating
                    refreshElements();
                    
                    // Update UI elements
                    if (el.codeDisplay) {
                        el.codeDisplay.textContent = code;
                    }
                    
                    if (el.hiddenField) {
                        el.hiddenField.value = code;
                    }
                    
                    // Update totals - always round up the final payable amount
                    var newTotal = parseFloat(body.new_total || state.originalGrandTotal);
                    var roundedTotal = Math.ceil(newTotal);
                    updateTotals(state.currentDiscount, roundedTotal);
                    
                    // Disable coupon field
                    disableCouponField();
                    if (el.removeBtn) {
                        el.removeBtn.focus();
                    }
                    
                    // Show success message
                    showMessage('success', body.message || 'Coupon applied successfully!');
                } else {
                    console.log('CheckoutCoupon: Coupon validation failed:', body.message);
                    // Error: Invalid coupon
                    var errorMsg = body.message || 'Invalid or expired coupon';
                    showMessage('error', errorMsg);
                    
                    // Keep field enabled for retry
                    refreshElements();
                    if (el.input) {
                        el.input.focus();
                        el.input.select();
                    }
                }
            })
            .catch(function(error) {
                console.error('CheckoutCoupon: Coupon apply error:', error);
                console.error('CheckoutCoupon: Error name:', error.name);
                console.error('CheckoutCoupon: Error message:', error.message);
                console.error('CheckoutCoupon: Error stack:', error.stack);
                showMessage('error', 'Network error. Please try again.');
                
                if (el.input) {
                    el.input.focus();
                }
            })
            .finally(function() {
                setApplying(false);
            });
    }

    // ============================================
    // Coupon Removal
    // ============================================
    function removeCoupon(e) {
        if (e && e.preventDefault) {
            e.preventDefault();
        }

        if (!state.currentCode) {
            // Nothing to remove, just reset UI
            resetUI();
            showMessage('info', 'No coupon applied');
            return;
        }

        clearMessage();
        
        // Send removal request to backend
        postJSON(ENDPOINT_REMOVE, { code: state.currentCode })
            .then(function(response) {
                var body = response.body || {};
                
                // Reset UI regardless of response
                resetUI();
                
                if (response.ok && body.success) {
                    showMessage('success', body.message || 'Coupon removed successfully');
                } else {
                    showMessage('warning', body.message || 'Coupon removed from checkout');
                }
            })
            .catch(function(error) {
                console.error('Coupon remove error:', error);
                // Still reset UI even if request fails
                resetUI();
                showMessage('warning', 'Coupon removed locally');
            });
    }

    // ============================================
    // Event Handlers
    // ============================================
    function formDelegateHandler(e) {
        if (!e || !e.target) return;
        
        // Check if clicked element is the button or inside the button
        var target = e.target;
        var isApplyBtn = false;
        var isRemoveBtn = false;
        
        // Check the target itself
        if (target.id === 'apply_coupon_btn') {
            isApplyBtn = true;
        } else if (target.id === 'remove_coupon_btn') {
            isRemoveBtn = true;
        } else {
            // Check if target is inside a button (e.g., clicked on span inside button)
            var parent = target.closest ? target.closest('button') : (function() {
                var el = target;
                while (el && el.tagName !== 'BUTTON') {
                    el = el.parentElement;
                }
                return el;
            })();
            
            if (parent) {
                if (parent.id === 'apply_coupon_btn') {
                    isApplyBtn = true;
                } else if (parent.id === 'remove_coupon_btn') {
                    isRemoveBtn = true;
                }
            }
        }
        
        if (isApplyBtn) {
            e.preventDefault();
            e.stopPropagation();
            console.log('CheckoutCoupon: Delegated click handler triggered (apply)');
            applyCoupon(e);
            return false;
        }
        
        if (isRemoveBtn) {
            e.preventDefault();
            e.stopPropagation();
            console.log('CheckoutCoupon: Delegated click handler triggered (remove)');
            removeCoupon(e);
            return false;
        }
    }

    function bindEvents() {
        console.log('CheckoutCoupon: bindEvents() called');
        
        // Refresh elements before binding (in case they were in collapsed panel)
        refreshElements();
        
        console.log('CheckoutCoupon: Elements found:', {
            input: !!el.input,
            applyBtn: !!el.applyBtn,
            removeBtn: !!el.removeBtn,
            message: !!el.message
        });
        
        // Use event delegation on document body to handle dynamically shown elements (bind once)
        // This ensures it works even if elements are in collapsed panels
        if (!state.delegationBound) {
            document.addEventListener('click', formDelegateHandler, true); // Use capture phase
            state.delegationBound = true;
            console.log('CheckoutCoupon: Event delegation bound to document');
        }

        // SIMPLIFIED: Direct event listeners - primary method
        // Try to find button directly, even if it's in collapsed panel
        var applyBtn = document.getElementById('apply_coupon_btn');
        var removeBtn = document.getElementById('remove_coupon_btn');
        
        if (applyBtn) {
            // Remove any existing listeners by cloning (clean slate)
            if (applyBtn.hasAttribute('data-bound')) {
                console.log('CheckoutCoupon: Apply button already has handler, skipping');
            } else {
                applyBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('CheckoutCoupon: DIRECT click handler triggered on apply button');
                    console.log('CheckoutCoupon: Event object:', e);
                    applyCoupon(e);
                });
                applyBtn.setAttribute('data-bound', 'true');
                console.log('CheckoutCoupon: ✓ Direct event listener attached to apply button');
            }
        } else {
            console.warn('CheckoutCoupon: ✗ Apply button NOT FOUND in DOM');
        }
        
        if (removeBtn) {
            if (removeBtn.hasAttribute('data-bound')) {
                console.log('CheckoutCoupon: Remove button already has handler, skipping');
            } else {
                removeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('CheckoutCoupon: Direct click handler triggered (remove)');
                    removeCoupon(e);
                });
                removeBtn.setAttribute('data-bound', 'true');
                console.log('CheckoutCoupon: ✓ Direct event listener attached to remove button');
            }
        } else {
            console.log('CheckoutCoupon: Remove button not found (this is OK if no coupon applied)');
        }

        // Enter key in coupon input - use keydown (keypress is deprecated)
        // Use document-level listener to catch events even in collapsed panels
        document.addEventListener('keydown', function(e) {
            if (e.target && e.target.id === 'coupon_code') {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    console.log('CheckoutCoupon: Enter key pressed in coupon input');
                    applyCoupon(e);
                }
            }
        });

        // Clear message when user starts typing
        document.addEventListener('input', function(e) {
            if (e.target && e.target.id === 'coupon_code') {
                refreshElements();
                if (el.input && el.input.value.trim() && el.message && el.message.textContent) {
                    clearMessage();
                }
            }
        });

        // Listen for Bootstrap collapse events to rebind when panel opens
        var couponPanel = document.getElementById('coupon');
        if (couponPanel) {
            couponPanel.addEventListener('shown.bs.collapse', function() {
                console.log('CheckoutCoupon: Coupon panel opened, re-binding events');
                // Re-bind events when panel opens (elements are now visible)
                setTimeout(function() {
                    var applyBtn = document.getElementById('apply_coupon_btn');
                    var removeBtn = document.getElementById('remove_coupon_btn');
                    
                    if (applyBtn && !applyBtn.hasAttribute('data-bound')) {
                        applyBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            console.log('CheckoutCoupon: Click handler triggered after panel open');
                            applyCoupon(e);
                        });
                        applyBtn.setAttribute('data-bound', 'true');
                        console.log('CheckoutCoupon: ✓ Event listener attached after panel open');
                    }
                    
                    if (removeBtn && !removeBtn.hasAttribute('data-bound')) {
                        removeBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            removeCoupon(e);
                        });
                        removeBtn.setAttribute('data-bound', 'true');
                    }
                }, 100);
            });
            
            // Also listen for when panel is about to show (in case elements become available)
            couponPanel.addEventListener('show.bs.collapse', function() {
                console.log('CheckoutCoupon: Coupon panel opening, elements will be available soon');
            });
        } else {
            console.warn('CheckoutCoupon: Coupon panel element not found');
        }
    }

    // ============================================
    // Initialization
    // ============================================
    function init() {
        console.log('CheckoutCoupon: Initializing...');
        
        // Refresh elements
        refreshElements();
        
        // Initialize original total
        initializeOriginalTotal();
        console.log('CheckoutCoupon: Original total:', state.originalGrandTotal);
        
        // Bind event listeners
        bindEvents();
        console.log('CheckoutCoupon: Events bound');
        
        // Check if a coupon is already applied (from session/page load)
        // This would be set by the backend if user refreshes page
        refreshElements();
        if (el.hiddenField && el.hiddenField.value) {
            state.currentCode = el.hiddenField.value;
            disableCouponField();
            console.log('CheckoutCoupon: Found existing coupon:', state.currentCode);
        }
        
        console.log('CheckoutCoupon: Initialization complete');
    }

    // Initialize when DOM is ready
    function startInit() {
        console.log('CheckoutCoupon: Starting initialization...');
        console.log('CheckoutCoupon: Document ready state:', document.readyState);
        
        // Small delay to ensure Bootstrap collapse is initialized
        setTimeout(function() {
            try {
                init();
            } catch (error) {
                console.error('CheckoutCoupon: Error during init:', error);
            }
            
            // Also try to bind events again after a longer delay in case elements weren't ready
            setTimeout(function() {
                console.log('CheckoutCoupon: Re-checking elements and re-binding if needed');
                try {
                    refreshElements();
                    var applyBtn = document.getElementById('apply_coupon_btn');
                    if (applyBtn && !applyBtn.hasAttribute('data-bound')) {
                        console.log('CheckoutCoupon: Re-binding apply button after delay');
                        applyBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            console.log('CheckoutCoupon: Late-bound click handler triggered');
                            applyCoupon(e);
                        });
                        applyBtn.setAttribute('data-bound', 'true');
                        console.log('CheckoutCoupon: ✓ Late-bound handler attached');
                    } else if (applyBtn) {
                        console.log('CheckoutCoupon: Apply button already has handler');
                    } else {
                        console.warn('CheckoutCoupon: Apply button still not found after delay');
                    }
                } catch (error) {
                    console.error('CheckoutCoupon: Error during late binding:', error);
                }
            }, 1000); // Increased delay to 1 second
        }, 200); // Increased initial delay
    }
    
    // Wrap in try-catch to prevent errors from blocking execution
    try {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', startInit);
        } else {
            startInit();
        }
    } catch (error) {
        console.error('CheckoutCoupon: Fatal error during initialization:', error);
    }

    // Expose public API (optional, for external access)
    root.CheckoutCoupon = {
        apply: applyCoupon,
        remove: removeCoupon,
        getState: function() {
            return {
                code: state.currentCode,
                discount: state.currentDiscount,
                originalTotal: state.originalGrandTotal
            };
        }
    };

})(window);
