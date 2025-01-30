<?php

function getWebDetails()
{

    define("PATH", 'localhost/virtup-web/src/json/home.json');

    $url = PATH;
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Content-Type: application/json',
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    if (curl_error($ch)) {
        return json_encode(["is_success" => false, "message_error" => "File Not Found", "response_code" => 404]);
    } else {
        return $response;
    }
}

$rawRes = getWebDetails();
$response = json_decode($rawRes);

$hasAbout = false;

$meta_name = "";
$meta_description = "";
$meta_company = "";
$meta_url = "";
$meta_color = "";

$about_logo = "";
$about_logo_alt = "";

if (isset($response->is_success) && $response->is_success === true) {
    $data = $response->data;
    foreach ($data as $section) {
        switch ($section->section) {
            case "metadata":
                if (isset($section->details)) {
                    if (isset($section->details->website_name)) {
                        $meta_name = $section->details->website_name;
                    }
                    if (isset($section->details->website_description)) {
                        $meta_description = $section->details->website_description;
                    }
                    if (isset($section->details->website_company)) {
                        $meta_company = $section->details->website_company;
                    }
                    if (isset($section->details->members_url)) {
                        $meta_url = $section->details->members_url;
                    }
                    if (isset($section->details->website_color)) {
                        $meta_color = $section->details->website_color;
                    }
                }
                break;
            case "about":
                $hasAbout = true;
                if (isset($section->details)) {
                    if (isset($section->details->logo)) {
                        if (isset($section->details->logo->path)) {
                            $about_logo = $section->details->logo->path;
                        }
                        if (isset($section->details->logo->alt)) {
                            $about_logo_alt = $section->details->logo->alt;
                        }
                    }
                }
                break;
            default:
        }
    }
}
?>
<html lang="en">

<head>
    <!-- SEO -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta name="title" content="<?php echo $meta_name; ?>" />
    <meta name="application-name" content="<?php echo $meta_name; ?>" />
    <meta name="og:site_name" content="<?php echo $meta_name; ?>" />
    <meta name="twitter:title" content="<?php echo $meta_name; ?>" />
    <meta property="og:title" content="<?php echo $meta_name; ?>" />
    <meta property="og:image:alt" content="<?php echo $meta_name; ?>">

    <meta property="og:type" content="website" />

    <meta name="keywords" content="virtup, vtuber, streamer, entertainment" />

    <meta name="author" content="<?php echo $meta_company; ?>" />
    <meta name="description" content="<?php echo $meta_description; ?>" />
    <meta property="og:description" content="<?php echo $meta_description; ?>" />
    <meta name="twitter:description" content="<?php echo $meta_description; ?>" />

    <meta property="og:url" content="<?php echo $meta_url; ?>">
    <meta name="twitter:url" content="<?php echo $meta_url; ?>" />
    <meta name="robots" content="index,follow" />

    <meta property="og:image" content="https://lucian.solutions/images/22t.jpg" />
    <meta property="og:image:secure_url" content="https://lucian.solutions/images/22t.jpg" />
    <meta name="twitter:image" content="https://lucian.solutions/images/22t.jpg" />

    <meta name="msapplication-TileColor" content="<?php echo $meta_color; ?>" />
    <meta name="theme-color" content="<?php echo $meta_color; ?>">
    <meta name="theme-color" media="(prefers-color-scheme: light)" content="<?php echo $meta_color; ?>" />
    <meta name="theme-color" media="(prefers-color-scheme: dark)" content="<?php echo $meta_color; ?>" />

    <title>VirtUp</title>
    <link rel="stylesheet" type="text/css" href="../src/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../src/css/icons/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" type="text/css" href="../src/css/extended.css" />
</head>

<body>
    <div class="position-fixed w-100" style="z-index:5;">
        <div class="px-md-5 px-4 d-flex flex-row justify-content-between navbar-custom">
            <a href=".." role="button">
                <div class="d-block">
                    <div class="d-flex flex-column h-100 justify-content-center">
                        <img src="<?php echo $about_logo ?>" alt="<?php echo $about_logo_alt ?> Logo" class="logo" loading="lazy" />
                    </div>
                </div>
            </a>
            <div class="d-md-block d-none">
                <div class="d-flex flex-row h-100">
                    <a href=".." class="d-block menu-btn">
                        <div class="d-flex flex-column h-100 justify-content-center">
                            <div class="d-block mx-3 menu-text">Home</div>
                        </div>
                        <div class="overlay-menu-btn"></div>
                    </a>
                    <a href="javascript:void(0)" class="d-block menu-btn" role="button" onclick="goToTop()">
                        <div class="d-flex flex-column h-100 justify-content-center">
                            <div class="d-block mx-3 menu-text">Our Virtual Influencers</div>
                        </div>
                        <div class="overlay-menu-btn"></div>
                    </a>
                    <a href="..#about" class="d-block menu-btn">
                        <div class="d-flex flex-column h-100 justify-content-center">
                            <div class="d-block mx-3 menu-text">About VirtUp</div>
                        </div>
                        <div class="overlay-menu-btn"></div>
                    </a>
                    <a href="..#contact" class="d-block menu-btn">
                        <div class="d-flex flex-column h-100 justify-content-center">
                            <div class="d-block mx-3 menu-text">Contact Us</div>
                        </div>
                        <div class="overlay-menu-btn"></div>
                    </a>
                </div>
            </div>
            <div class="d-md-none d-block" role="button" onclick="toggleMobileNav()">
                <div class="d-flex flex-column h-100 justify-content-center" id="hamburger_menu">
                    <i class="bi bi-list text-white display-3"></i>
                </div>
            </div>
        </div>
        <div class="px-md-5 px-4 py-2 d-md-none hideMenu" id="mobileNav">
            <div class="d-flex flex-row justify-content-end">
                <div class="navbar-custom rounded-3">
                    <a href=".." role="button" class="text-white text-decoration-none" onclick="toggleMobileNav();">
                        <div class="d-block mobile-nav-item text-end">Home</div>
                    </a>
                    <a href="javascript:void(0)" class="text-white text-decoration-none" role="button"
                        onclick="goToTop();toggleMobileNav();">
                        <div class="d-block mobile-nav-item text-end">Our Virtual Influencers</div>
                    </a>
                    <a href="..#about" class="text-white text-decoration-none" onclick="toggleMobileNav();">
                        <div class="d-block mobile-nav-item text-end">About VirtUp</div>
                    </a>
                    <a href="..#contact" class="text-white text-decoration-none" onclick="toggleMobileNav();">
                        <div class="d-block mobile-nav-item text-end">Contact Us</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="banner2" class="d-flex flex-column justify-content-end pb-5 text-center banner fade-in-onload">
        <i class="display-6 bi bi-chevron-down scroll-down-text"></i>
        <small class="scroll-down-text">Scroll Down</small>
    </div>

    <div class="min-vh-100 d-flex flex-column justify-content-center" name="content">
        <div class="container-fluid content-scroll fade-in" id="about">
            <div class="container-md my-md-5 my-2 text-white">
                <div class="row">
                    <div class="col-md-12 my-auto">
                        <div class="d-flex flex-column justify-content-center">
                            <h1 class="display-1 text-center pb-3 mb-3 accented" id="loading"><i
                                    class="bi bi-star-fill"></i></h1>
                            <h1 class="display-4 text-center pb-3 mb-3">Coming Soon</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <p class="text-white text-center mt-md-5 mt-2">&copy;&nbsp;All Rights reserved by VirtUp Entertainment Co., Ltd.
            <small class="text-secondary">2024-<?php echo date("Y"); ?></small></p>
    </div>

</body>
<script type="text/javascript" src="../src/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../src/js/jquery.min.js"></script>
<script type="text/javascript" src="../src/js/extended.js"></script>
<script type="text/javascript" src="../src/js/mobile_menu.js"></script>
<script>
    $("#banner").ready(function () {
        $('.fade-in-onload').each(function () {
            var top_of_element = $(this).offset().top;
            var bottom_of_element = $(this).offset().top + $(this).outerHeight();
            var bottom_of_screen = $(window).scrollTop() + $(window).innerHeight();
            var top_of_screen = $(window).scrollTop();

            if ((bottom_of_screen > top_of_element) && (top_of_screen < bottom_of_element) && !$(this).hasClass('is-visible')) {
                $(this).addClass('is-visible');
            }
        });
    });

    $(window).scroll(function () {
        $('.fade-in').each(function () {
            var top_of_element = $(this).offset().top;
            var bottom_of_element = $(this).offset().top + $(this).outerHeight();
            var bottom_of_screen = $(window).scrollTop() + $(window).innerHeight();
            var top_of_screen = $(window).scrollTop();

            if ((bottom_of_screen > top_of_element) && (top_of_screen < bottom_of_element) && !$(this).hasClass('is-visible')) {
                $(this).addClass('is-visible');
            }
        });
    });
</script>

</html>