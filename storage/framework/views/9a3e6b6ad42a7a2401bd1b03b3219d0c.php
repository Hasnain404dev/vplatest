<?php $__env->startSection('content'); ?>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="<?php echo e(route('frontend.home')); ?>" rel="nofollow">Home</a>
                    <span></span> Blog <span></span> Technology
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container custom">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="single-header mb-50 text-center">
                            <h1 class="font-xxl text-brand">Our Blog</h1>
                        </div>
                        <div class="loop-grid pr-30">
                            <div class="row">
                                <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-lg-4">
                                        <article class="wow fadeIn animated hover-up mb-30">
                                            <div class="post-thumb img-hover-scale">
                                                <a href="<?php echo e(route('frontend.blogDetail', $blog)); ?>">
                                                    <img src="<?php echo e(asset('uploads/blogs/' . $blog->image)); ?>"
                                                        alt=""  loading="lazy" decoding="async" />
                                                </a>
                                            </div>
                                            <div class="entry-content-2">
                                                <h3 class="post-title mb-15">
                                                    <a href="<?php echo e(route('frontend.blogDetail', $blog)); ?>"><?php echo e($blog->title); ?></a>
                                                </h3>
                                                <p class="post-exerpt mb-30">
                                                    <?php echo e($blog->description); ?>

                                                </p>
                                                <div class="entry-meta meta-1 font-xs color-grey mt-10 pb-10">
                                                    <div>
                                                        <span class="post-on">
                                                            <i class="fi-rs-clock"></i>
                                                            <?php echo e($blog->created_at->format('d M Y')); ?></span>
                                                    </div>
                                                    <a href="<?php echo e(route('frontend.blogDetail', $blog)); ?>" class="text-brand">Read more <i
                                                            class="fi-rs-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <!--post-grid-->
                        <div class="pagination-area mt-15 mb-lg-0">
                            <?php echo e($blogs->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\frontend\blog.blade.php ENDPATH**/ ?>