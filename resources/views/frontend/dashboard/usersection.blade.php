<section class="inner-banner bg_img"
         style="background: linear-gradient(135deg, #30cfd0 0%, #086755 100%);"
         role="banner"
         aria-label="User Dashboard Header">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xl-6 text-center">
                <h1 class="title text-white mb-0">
                    {{ trans_db('User Dashboard', 'User Dashboard') }}
                </h1>

            </div>
        </div>
    </div>
</section>

<style>
    .inner-banner {
        padding: 80px 0;
        position: relative;
        overflow: hidden;
    }

    .inner-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.1);
        pointer-events: none;
    }

    .inner-banner .title {
        font-size: 2.5rem;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        position: relative;
        z-index: 1;
    }

    .inner-banner .breadcrumb-item a:hover {
        opacity: 0.8;
        text-decoration: underline !important;
    }

    .inner-banner .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.7);
    }

    @media (max-width: 768px) {
        .inner-banner {
            padding: 60px 0;
        }

        .inner-banner .title {
            font-size: 2rem;
        }
    }

    @media (max-width: 576px) {
        .inner-banner {
            padding: 40px 0;
        }

        .inner-banner .title {
            font-size: 1.75rem;
        }
    }
</style>
