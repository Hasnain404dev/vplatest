<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-12">
            <div class="content-header d-flex justify-content-between align-items-center">
                <h2 class="content-title">Add New Slider</h2>
                <button type="submit" form="sliderForm" class="btn btn-md rounded font-sm hover-up">Publish</button>
            </div>
        </div>
        <div class="col-12">
            <form id="sliderForm" action="<?php echo e(route('admin.sliders.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="image_desktop" class="form-label required">Desktop Banner*  </label>
                                    <input type="file" class="form-control <?php $__errorArgs = ['image_desktop'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="image_desktop" name="image_desktop" required>
                                    <?php $__errorArgs = ['image_desktop'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="text-muted">Recommended: 1600×600 (JPEG/PNG, max 4MB)</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="image_mobile" class="form-label">Mobile Banner (optional)</label>
                                    <input type="file" class="form-control <?php $__errorArgs = ['image_mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="image_mobile" name="image_mobile">
                                    <?php $__errorArgs = ['image_mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="text-muted">Recommended: 750×1000 (portrait), otherwise desktop will be used</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="heading" class="form-label">Heading</label>
                                    <input type="text" class="form-control" id="heading" name="heading" value="<?php echo e(old('heading')); ?>">
                                    <?php $__errorArgs = ['heading'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="sub_heading" class="form-label">Sub Heading</label>
                                    <input type="text" class="form-control" id="sub_heading" name="sub_heading" value="<?php echo e(old('sub_heading')); ?>">
                                    <?php $__errorArgs = ['sub_heading'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="paragraph" class="form-label">Paragraph</label>
                                    <textarea class="form-control" id="paragraph" name="paragraph" rows="3"><?php echo e(old('paragraph')); ?></textarea>
                                    <?php $__errorArgs = ['paragraph'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Heading color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" class="form-control form-control-color" id="heading_color_picker" value="#ffffff" style="width:3rem;height:2.25rem;">
                                        <input type="text" class="form-control" id="heading_color" name="heading_color" value="<?php echo e(old('heading_color')); ?>" placeholder="#ffffff">
                                    </div>
                                    <?php $__errorArgs = ['heading_color'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Sub heading color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" class="form-control form-control-color" id="sub_heading_color_picker" value="#ffffff" style="width:3rem;height:2.25rem;">
                                        <input type="text" class="form-control" id="sub_heading_color" name="sub_heading_color" value="<?php echo e(old('sub_heading_color')); ?>" placeholder="#ffffff">
                                    </div>
                                    <?php $__errorArgs = ['sub_heading_color'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Paragraph text color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" class="form-control form-control-color" id="paragraph_color_picker" value="#ffffff" style="width:3rem;height:2.25rem;">
                                        <input type="text" class="form-control" id="paragraph_color" name="paragraph_color" value="<?php echo e(old('paragraph_color')); ?>" placeholder="#ffffff">
                                    </div>
                                    <?php $__errorArgs = ['paragraph_color'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="button_name" class="form-label">Button Name</label>
                                    <input type="text" class="form-control" id="button_name" name="button_name" value="<?php echo e(old('button_name')); ?>">
                                    <?php $__errorArgs = ['button_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="button_link" class="form-label">Button Link</label>
                                    <input type="url" class="form-control" id="button_link" name="button_link" value="<?php echo e(old('button_link')); ?>">
                                    <?php $__errorArgs = ['button_link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="background_opacity" class="form-label">Background overlay opacity</label>
                                    <input type="range" class="form-range" id="background_opacity" name="background_opacity" min="0" max="100" value="<?php echo e(old('background_opacity', 40)); ?>">
                                    <small class="text-muted"><span id="background_opacity_val">40</span>% (darker = more readable text)</small>
                                    <?php $__errorArgs = ['background_opacity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="text_color" class="form-label">Text color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" class="form-control form-control-color" id="text_color_picker" value="#ffffff" style="width:3rem;height:2.25rem;">
                                        <input type="text" class="form-control" id="text_color" name="text_color" value="<?php echo e(old('text_color', '#ffffff')); ?>" placeholder="#ffffff">
                                    </div>
                                    <?php $__errorArgs = ['text_color'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Button background color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" class="form-control form-control-color" id="button_bg_color_picker" value="#0d6efd" style="width:3rem;height:2.25rem;">
                                        <input type="text" class="form-control" id="button_bg_color" name="button_bg_color" value="<?php echo e(old('button_bg_color', '#0d6efd')); ?>" placeholder="#0d6efd">
                                    </div>
                                    <?php $__errorArgs = ['button_bg_color'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="text-muted">Legacy field still supported: Button color</small>
                                    <div class="d-flex align-items-center gap-2 mt-1">
                                        <input type="color" class="form-control form-control-color" id="button_color_picker" value="#0d6efd" style="width:3rem;height:2.25rem;">
                                        <input type="text" class="form-control" id="button_color" name="button_color" value="<?php echo e(old('button_color')); ?>" placeholder="#0d6efd">
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Button text color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" class="form-control form-control-color" id="button_text_color_picker" value="#ffffff" style="width:3rem;height:2.25rem;">
                                        <input type="text" class="form-control" id="button_text_color" name="button_text_color" value="<?php echo e(old('button_text_color', '#ffffff')); ?>" placeholder="#ffffff">
                                    </div>
                                    <?php $__errorArgs = ['button_text_color'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="order" class="form-label">Order</label>
                                    <input type="number" class="form-control" id="order" name="order" value="<?php echo e(old('order', 0)); ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" <?php echo e(old('is_active', true) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="is_active">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3">
                    <a href="<?php echo e(route('admin.sliders')); ?>" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Slider</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('background_opacity').addEventListener('input', function() {
            document.getElementById('background_opacity_val').textContent = this.value;
        });
        // Per-element color pickers sync
        function bindColorSync(pickerId, textId){
            var p = document.getElementById(pickerId);
            var t = document.getElementById(textId);
            if(!p || !t) return;
            p.addEventListener('input', function(){ t.value = this.value; });
            t.addEventListener('input', function(){ if(/^#[0-9A-Fa-f]{6}$/.test(this.value)) p.value = this.value; });
        }
        document.getElementById('text_color_picker').addEventListener('input', function() {
            document.getElementById('text_color').value = this.value;
        });
        document.getElementById('text_color').addEventListener('input', function() {
            if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) document.getElementById('text_color_picker').value = this.value;
        });
        bindColorSync('button_color_picker','button_color');
        bindColorSync('button_bg_color_picker','button_bg_color');
        bindColorSync('button_text_color_picker','button_text_color');
        bindColorSync('heading_color_picker','heading_color');
        bindColorSync('sub_heading_color_picker','sub_heading_color');
        bindColorSync('paragraph_color_picker','paragraph_color');
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views/backend/sliders/create.blade.php ENDPATH**/ ?>