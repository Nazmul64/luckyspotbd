<section class="inner-banner bg_img" style="background: url('{{ asset('assets/images/inner-banner/bg2.jpg') }}') top;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xl-6 text-center">
                <h2 class="title text-white">{{ trans_db('User Dashboard', 'User Dashboard') }}</h2>
            </div>
        </div>
    </div>
</section>
{{-- <style>
    .inner-banner-wrapper {
        position: relative;
    }

    .inner-banner-wrapper::before {
        content: '';
        position: absolute;
        top: -5px;
        left: -5px;
        right: -5px;
        bottom: -5px;
        background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
        z-index: -1;
        box-shadow:
            0 15px 50px rgba(51, 8, 103, 0.4),
            0 8px 25px rgba(48, 207, 208, 0.3),
            inset 0 2px 0 rgba(255, 255, 255, 0.15);
    }

    .inner-banner {
        position: relative;
        overflow: hidden;
    }

    .inner-banner::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(48, 207, 208, 0.3) 0%, rgba(51, 8, 103, 0.5) 100%);
        z-index: 1;
    }

    .inner-banner .container {
        position: relative;
        z-index: 2;
    }

    .banner-title-wrapper {
        position: relative;
        display: inline-block;
        padding: 20px 40px;
    }

    .banner-title-wrapper::before {
        content: '';
        position: absolute;
        top: -3px;
        left: -3px;
        right: -3px;
        bottom: -3px;
        background: linear-gradient(135deg, rgba(48, 207, 208, 0.4) 0%, rgba(51, 8, 103, 0.6) 100%);
        border-radius: 15px;
        z-index: -1;
        box-shadow:
            0 8px 30px rgba(51, 8, 103, 0.5),
            0 4px 15px rgba(48, 207, 208, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .banner-title {
        position: relative;
        text-shadow:
            0 4px 15px rgba(0, 0, 0, 0.5),
            0 2px 8px rgba(51, 8, 103, 0.7),
            0 0 30px rgba(48, 207, 208, 0.5);
        font-weight: bold;
        letter-spacing: 1px;
    }

    /* Animated Gradient Border */
    @keyframes gradientShift {
        0%, 100% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
    }

    .inner-banner-wrapper::before {
        background: linear-gradient(135deg, #30cfd0 0%, #330867 50%, #30cfd0 100%);
        background-size: 200% 200%;
        animation: gradientShift 5s ease infinite;
    }
</style>

<div class="inner-banner-wrapper">
    <section class="inner-banner bg_img"
             style="background: url('{{ asset('assets/images/inner-banner/bg2.jpg') }}') top;
                    background-size: cover;
                    background-position: center;
                    padding: 80px 0;
                    position: relative;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-xl-6 text-center">
                    <div class="banner-title-wrapper">
                        <h2 class="title text-white banner-title"
                            style="margin: 0;
                                   font-size: 2.5em;
                                   color: #ffffff;">
                            {{ trans_db('User Dashboard', 'User Dashboard') }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
(function() {
    'use strict';

    // Add hover effect to banner title
    const bannerTitle = document.querySelector('.banner-title-wrapper');

    if (bannerTitle) {
        bannerTitle.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
            this.style.transition = 'all 0.3s ease';
        });

        bannerTitle.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    }

    // Parallax scroll effect
    const innerBanner = document.querySelector('.inner-banner');

    if (innerBanner) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const parallaxSpeed = 0.5;
            innerBanner.style.backgroundPositionY = (scrolled * parallaxSpeed) + 'px';
        });
    }
})();
</script> --}}

