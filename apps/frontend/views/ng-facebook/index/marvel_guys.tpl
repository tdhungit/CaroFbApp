<link rel="stylesheet" href="{{ static_url(theme_uri) }}/css/marvel_guys.css">
<div id="container" class="" ng-controller="MarvelGuysController">
    <!-- +++ Intro Section ++++ -->
    <section class="intro">
        <!-- Intro Section Background-image -->
        <div class="intro-image"></div>

        <!-- ====+++ Intro Section Content +++==== -->
        <div class="center-content">


            <div class="intro-content text-center">
                <!-- Logo -->
                <div class="logo">
                    <h2 class="text-logo">BẠN LÀ NHÂN VẬT NÀO TRONG MARVEL</h2>
                </div><!-- /End logo -->

                <!-- Spin Clock -->
                <i class="fa fa-clock-o fa-spin fa-4x fa-clock-spin"></i>

                <!-- ====+++ Result +++==== -->
                <div class="intro-subtitle">
                    <afb:login ng-if="!is_result" label=" XEM " scope="email, read_stream, read_friendlists, user_birthday, user_education_history, user_location" class="btn btn-info btn-lg" style="width: 200px"></afb:login>
                    <h2 ng-if="is_result">{{ ng('game_result') }}</h2>
                </div>
            </div> <!-- /End Intro Section Content -->
        </div>
        <!-- ==== Intro Section Bottom Content ==== -->
        <div class="container-bottom-content">
            <!-- ==== Social Links ==== -->
            <div class="social">
                <a href="https://www.facebook.com"><i class="fa fa-facebook fa-2x fa-social"></i></a>
                <a href="https://www.twitter.com"><i class="fa fa-twitter fa-2x fa-social"></i></a>
                <a href="https://www.linkedin.com"><i class="fa fa-linkedin fa-2x fa-social"></i></a>
                <a href="https://www.plus.google.com"><i class="fa fa-google-plus fa-2x fa-social"></i></a>
            </div> <!-- /End Social Links -->

            <!-- ==== Notify Section ==== -->
            <div class="notify-after text-center">
                <h2>Notify Me</h2>
                <p>Subscribe our mail list for Latest update</p>
                <form id="mc-form" class="form-inline" role="form" novalidate="true">
                    <div class="form-group subscribe-form">
                        <input id="mc-email" type="email" placeholder="Your email" class="form-control input-label input-notify-after" name="EMAIL">
                        <button type="submit" class="btn btn-default btn-notify-after"><i class="fa fa-send-o"></i></button>
                    </div><!-- End email input -->
                    <div class="subscribe_lebel">
                        <label for="mc-email"></label>
                    </div>
                </form>
            </div> <!-- /End Notify Section -->
        </div> <!-- /End Intro Section Bottom Content -->
    </section><!-- /end intro section -->
</div>