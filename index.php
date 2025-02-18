<?php

error_reporting(E_ERROR | E_PARSE);
function getWebDetails()
{
    define("PATH", dirname(__DIR__) . '/virtup-web/src/json/home.json');

    try {
        $json = file_get_contents(PATH);
    } catch (Error $e) {
        exit;
    }

    if (!$json) {
        return json_encode(["is_success" => false, "message_error" => "File Not Found", "response_code" => 404]);
    } else {
        return $json;
    }
}

$rawRes = getWebDetails();
$response = json_decode($rawRes);

$hasAbout = false;
$hasContact = false;
$hasSocials = false;

$meta_name = "";
$meta_description = "";
$meta_company = "";
$meta_url = "";
$meta_color = "";

$about_title = "";
$about_subtitle = "";
$about_description = "";
$about_logo = "";
$about_logo_alt = "";
$about_video = "";

$contact_title = "";
$contact_subtitle = "";
$contact_address = "";
$contact_email = "";
$contact_phone = "";
$contact_phone_name = "";

$contact_social_facebook = "";
$contact_social_x = "";
$contact_social_youtube = "";

$social_facebook = [];
$social_x = [];
$social_youtube = [];

$all_social_facebook = ['<a href="', '" role="button" class="btn btn-outline-primary rounded-0 border-0 w-100"><div class="fw-bold my-2">', '</div></a>'];
$all_social_x = ['<a href="', '" role="button" class="btn btn-outline-dark rounded-0 border-0 w-100"><div class="fw-bold my-2">', '</div></a>'];
$all_social_youtube = ['<a href="', '" role="button" class="btn btn-outline-danger rounded-0 border-0 w-100"><div class="fw-bold my-2">', '</div></a>'];

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
                    if (isset($section->details->website_url)) {
                        $meta_url = $section->details->website_url;
                    }
                    if (isset($section->details->website_color)) {
                        $meta_color = $section->details->website_color;
                    }
                }
                break;
            case "about":
                $hasAbout = true;
                if (isset($section->details)) {
                    if (isset($section->details->title)) {
                        $about_title = $section->details->title;
                    }
                    if (isset($section->details->subtitle)) {
                        $about_subtitle = $section->details->subtitle;
                    }
                    if (isset($section->details->description)) {
                        $about_description = $section->details->description;
                    }
                    if (isset($section->details->logo)) {
                        if (isset($section->details->logo->path)) {
                            $about_logo = $section->details->logo->path;
                        }
                        if (isset($section->details->logo->alt)) {
                            $about_logo_alt = $section->details->logo->alt;
                        }
                    }
                    if (isset($section->details->video)) {
                        $about_video = $section->details->video;
                    }
                }
                break;
            case "contact":
                $hasContact = true;
                if (isset($section->details)) {
                    if (isset($section->details->title)) {
                        $contact_title = $section->details->title;
                    }
                    if (isset($section->details->subtitle)) {
                        $contact_subtitle = $section->details->subtitle;
                    }
                    if (isset($section->details->address)) {
                        $contact_address = $section->details->address;
                    }
                    if (isset($section->details->email)) {
                        $contact_email = $section->details->email;
                    }
                    if (isset($section->details->phone)) {
                        $contact_phone = $section->details->phone;
                    }
                    if (isset($section->details->phone_name)) {
                        $contact_phone_name = $section->details->phone_name;
                    }
                    if (isset($section->details->social)) {
                        if (isset($section->details->social->facebook)) {
                            $contact_social_facebook = $section->details->social->facebook;
                        }
                        if (isset($section->details->social->x)) {
                            $contact_social_x = $section->details->social->x;
                        }
                        if (isset($section->details->social->youtube)) {
                            $contact_social_youtube = $section->details->social->youtube;
                        }
                    }
                }
                break;
            case "socials":
                $hasSocials = true;
                if (isset($section->details)) {
                    if (isset($section->details->social)) {
                        if (isset($section->details->social->facebook)) {
                            $social_facebook = $section->details->social->facebook;
                        }
                        if (isset($section->details->social->x)) {
                            $social_x = $section->details->social->x;
                        }
                        if (isset($section->details->social->youtube)) {
                            $social_youtube = $section->details->social->youtube;
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

    <meta property="og:image" content="<?php echo $about_logo ?>" />
    <meta property="og:image:secure_url" content="<?php echo $about_logo ?>" />
    <meta name="twitter:image" content="<?php echo $about_logo ?>" />

    <meta name="msapplication-TileColor" content="<?php echo $meta_color; ?>" />
    <meta name="theme-color" content="<?php echo $meta_color; ?>">
    <meta name="theme-color" media="(prefers-color-scheme: light)" content="<?php echo $meta_color; ?>" />
    <meta name="theme-color" media="(prefers-color-scheme: dark)" content="<?php echo $meta_color; ?>" />

    <title><?php echo $meta_name; ?></title>
    <link rel="shortcut icon" href="/virtup-web/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/android-icon-512x512.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="stylesheet" type="text/css" href="src/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="src/css/icons/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" type="text/css" href="src/css/extended.css" />
</head>

<body class="position-relative" style="width: 100vw; overflow-x: hidden;">
    <section id="top-section">
        <div class="position-fixed vw-100" style="z-index:5;">
            <div class="px-md-5 px-4 d-flex flex-row justify-content-between navbar-custom" style="min-height: 5rem;">
                <div class="d-block" role="button" onclick="goToTop()">
                    <div class="d-flex flex-column h-100 justify-content-center">
                        <div class="d-block py-3"><img id="menu-logo" <?php echo $about_logo ? '' : 'style="display: none !important;"' ?> src="<?php echo $about_logo ?? "" ?>"
                                alt="<?php echo $about_logo_alt ?> Logo" class="logo d-inline-block" /></div>
                    </div>
                </div>
                <div class="d-lg-block d-none">
                    <div class="d-flex flex-row h-100">
                        <a href="javascript:void(0)" class="d-block menu-btn" role="button" onclick="goToTop();">
                            <div class="d-flex flex-column h-100 justify-content-center">
                                <div class="d-block mx-3 menu-text">Home</div>
                            </div>
                            <div class="overlay-menu-btn"></div>
                        </a>
                        <a href="#virtual-influencers" class="d-block menu-btn">
                            <div class="d-flex flex-column h-100 justify-content-center">
                                <div class="d-block mx-3 menu-text">Our Virtual Influencers</div>
                            </div>
                            <div class="overlay-menu-btn"></div>
                        </a>
                        <a href="#about" class="d-block menu-btn">
                            <div class="d-flex flex-column h-100 justify-content-center">
                                <div class="d-block mx-3 menu-text">About VirtUp</div>
                            </div>
                            <div class="overlay-menu-btn"></div>
                        </a>
                        <a href="#contact" class="d-block menu-btn">
                            <div class="d-flex flex-column h-100 justify-content-center">
                                <div class="d-block mx-3 menu-text">Contact Us</div>
                            </div>
                            <div class="overlay-menu-btn"></div>
                        </a>
                    </div>
                </div>
                <div class="d-lg-none d-flex" role="button" onclick="toggleMobileNav()" aria-label="Open the menu">
                    <div class="d-flex flex-column h-100 justify-content-center" id="hamburger_menu" aria-hidden=”true”>
                        <i class="bi bi-list text-white"></i>
                    </div>
                </div>
            </div>
            <div class="px-md-5 px-4 py-2 d-lg-none hideMenu" id="mobileNav">
                <div class="d-flex flex-row justify-content-end">
                    <div class="navbar-custom rounded-3">
                        <a href="javascript:void(0)" role="button" class="text-white text-decoration-none" role="button"
                            onclick="goToTop();toggleMobileNav();">
                            <div class="d-block mobile-nav-item text-end text-white">Home</div>
                        </a>
                        <a href="#virtual-influencers" class="text-black text-decoration-none"
                            onclick="toggleMobileNav();">
                            <div class="d-block mobile-nav-item text-end text-white">Our Virtual Influencers</div>
                        </a>
                        <a href="#about" class="text-black text-decoration-none" onclick="toggleMobileNav();">
                            <div class="d-block mobile-nav-item text-end text-white">About VirtUp</div>
                        </a>
                        <a href="#contact" class="text-black text-decoration-none" onclick="toggleMobileNav();">
                            <div class="d-block mobile-nav-item text-end text-white">Contact Us</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-100 vh-100 position-absolute d-flex flex-column justify-content-end" id="banner-hover">
            <a href="#socials" role="button" class="scroll-down-btn">
                <div class="position-relative w-100 h-100" style="pointer-events: none;">
                    <div class="move-up-down mb-5">
                        <i class="bi bi-chevron-down display-4"></i>
                    </div>
                </div>
            </a>
        </div>

        <div id="banner" class="text-center banner">
            <video class="<?php echo $hasContact == true && $about_video ? "lazy" : "d-none" ?>" autoplay playsinline muted
                loop id="cover-video" disablePictureInPicture controlsList="nodownload">
                <source src="<?php echo $about_video ?>" type="video/mp4">
            </video>
        </div>

        <div class="container-fluid<?php echo $hasContact == true ? "" : " d-none" ?>" id="socials"
            style="scroll-margin-top: 5em;">
            <div class="row" id="social-row">
                <div class="d-block col-4 social-btn social-btn-x" id="social-row-x">
                    <div class="d-flex flex-column h-100 justify-content-center">
                        <div class="d-block mx-3 my-5 social-text social-text-x">
                            <i class="bi bi-twitter-x fs-1"></i>
                            <div class="text-nowrap mt-2 lead d-sm-block d-none">Twitter / X</div>
                        </div>
                    </div>
                    <div class="overlay-social-btn overlay-social-btn-x"></div>
                    <?php
                    if ($hasSocials && count($social_x) > 0) {
                        echo '<div class="position-absolute d-block w-100 translate-middle-x start-50 top-100" style="z-index:2;" id="social-row-x-hover">';
                        echo '<div class="bg-white shadow d-flex flex-column">';
                        foreach ($social_x as $link) {
                            echo $all_social_x[0] . $link->url . $all_social_x[1] . $link->name . $all_social_x[2];
                        }
                        echo '</div></div>';
                    }
                    ?>
                </div>
                <div class="d-block col-4 social-btn" id="social-row-youtube">
                    <div class="d-flex flex-column h-100 justify-content-center">
                        <div class="d-block mx-3 my-5 social-text">
                            <i class="bi bi-youtube fs-1"></i>
                            <div class="text-nowrap mt-2 lead d-sm-block d-none">YouTube</div>
                        </div>
                    </div>
                    <div class="overlay-social-btn overlay-social-btn-youtube"></div>
                    <?php
                    if ($hasSocials && count($social_youtube) > 0) {
                        echo '<div class="position-absolute d-block w-100 translate-middle-x start-50 top-100" style="z-index:2;" id="social-row-youtube-hover">';
                        echo '<div class="bg-white shadow d-flex flex-column">';
                        foreach ($social_youtube as $link) {
                            echo $all_social_youtube[0] . $link->url . $all_social_youtube[1] . $link->name . $all_social_youtube[2];
                        }
                        echo '</div></div>';
                    }
                    ?>
                </div>
                <div class="d-block col-4 social-btn" id="social-row-facebook">
                    <div class="d-flex flex-column h-100 justify-content-center">
                        <div class="d-block mx-3 my-5 social-text">
                            <i class="bi bi-facebook fs-1"></i>
                            <div class="text-nowrap mt-2 lead d-sm-block d-none">Facebook</div>
                        </div>
                    </div>
                    <div class="overlay-social-btn overlay-social-btn-facebook"></div>
                    <?php
                    if ($hasSocials && count($social_facebook) > 0) {
                        echo '<div class="position-absolute d-block w-100 translate-middle-x start-50 top-100" style="z-index:2;" id="social-row-facebook-hover">';
                        echo '<div class="bg-white shadow d-flex flex-column">';
                        foreach ($social_facebook as $link) {
                            echo $all_social_facebook[0] . $link->url . $all_social_facebook[1] . $link->name . $all_social_facebook[2];
                        }
                        echo '</div></div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <div class="min-vh-100 d-flex flex-column justify-content-center pt-3" id="content" name="content">
        <section id="virtual-influencers-section">
            <div class="container-fluid content-scroll fade-in" id="virtual-influencers"
                style="display: none; scroll-margin-top: 7em;">
                <div class="container-lg my-lg-3 my-2 text-black bg-white shadow-sm p-5 rounded-3"
                    id="virtual-influencers-info">
                    <div class="text-center py-5">
                        <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="about-section">
            <div class="<?php echo $hasAbout == true ? "container-fluid content-scroll fade-in" : "d-none"; ?>"
                id="about" style="scroll-margin-top: 7em;">
                <div class="container-lg my-lg-3 my-2 text-black bg-white shadow-sm p-5 rounded-3">
                    <div class="row">
                        <div class="col-lg-4 my-auto">
                            <div class="d-flex flex-column justify-content-center">
                                <h1 class="display-6 text-center"><img src="<?php echo $about_logo ?>"
                                        alt="<?php echo $about_logo_alt ?>" id="about-logo" class="logo-about"
                                        loading="lazy" /></h1>
                            </div>
                        </div>
                        <div class="col-lg-8 my-auto">
                            <div class="d-flex flex-column justify-content-center">
                                <h1 class="display-6 pb-3 mb-3 header" id="about-title"><?php echo $about_title ?></h1>
                                <p class="lead" id="about-subtitle"><?php echo $about_subtitle ?></p>
                                <p id="about-description"><?php echo $about_description ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact-section">
            <div class="<?php echo $hasContact == true ? "container-fluid content-scroll fade-in" : "d-none"; ?>"
                id="contact" style="scroll-margin-top: 7em;">
                <div class="container-lg my-lg-3 my-2 text-black bg-white shadow-sm p-5 rounded-3">
                    <div class="row">
                        <div class="col-lg-8 my-auto">
                            <div class="d-flex flex-column justify-content-center">
                                <h1 class="display-6 pb-3 mb-3 header" id="contact-title"><?php echo $contact_title ?>
                                </h1>
                                <p class="lead" id="contact-subtitle"><?php echo $contact_subtitle ?></p>
                                <p id="contact-address"><?php echo $contact_address ?></p>
                            </div>
                        </div>
                        <div class="col-lg-4 my-auto">
                            <div class="d-flex flex-column justify-content-center">
                                <p class="text-lg-end text-start mb-0 text-nowrap"><span class="lead"><i
                                            class="bi bi-envelope accented me-2"></i><span
                                            id="contact-email"></span></span></p>
                                <p class="text-lg-end text-start text-nowrap"><span class="lead"><i
                                            class="bi bi-telephone accented me-2"></i><span
                                            id="contact-phone"><?php echo $contact_phone ?></span></span>&nbsp;<?php echo $contact_phone_name !== "" ? "(" : "" ?><span
                                        id="contact-phone-name"><?php echo $contact_phone_name ?></span><?php echo $contact_phone_name !== "" ? ")" : "" ?>
                                </p>
                                <p class="text-lg-end text-center mt-2 mb-0">
                                    <a href="<?php echo $contact_social_facebook ?? "javascript:void(0)" ?>"
                                        role="button" target="_blank" id="social-facebook"
                                        class="btn btn-outline-primary p-3 rounded-pill border-0"><i
                                            class="bi bi-facebook fs-4"></i></a>
                                    <a href="<?php echo $contact_social_x ?? "javascript:void(0)" ?>" role="button"
                                        target="_blank" id="social-x"
                                        class="btn btn-outline-dark p-3 rounded-pill border-0"><i
                                            class="bi bi-twitter-x fs-4"></i></a>
                                    <a href="<?php echo $contact_social_youtube ?? "javascript:void(0)" ?>"
                                        role="button" target="_blank" id="social-youtube"
                                        class="btn btn-outline-danger p-3 rounded-pill border-0"><i
                                            class="bi bi-youtube fs-4"></i></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <p class="text-center mt-md-3 mt-2">&copy;&nbsp;All Rights reserved by VirtUp Entertainment Co., Ltd.
            <small class="text-secondary">2024-<?php echo date("Y"); ?></small>
        </p>
    </div>

    <div class="member-popup" id="fullMemberInfo" style="pointer-events: none;">
        <div class="position-relative w-100 h-100">
            <div class="close-x-btn" role="button" onclick="closeMemberInfo()">
                <i class="bi bi-x-lg display-4"></i>
            </div>
            <div class="w-100 h-100 mx-auto my-auto position-absolute" id="fullMemberInfoBody">
            </div>
        </div>
    </div>

</body>
<script type="text/javascript" src="src/js/bootstrap.min.js"></script>
<script type="text/javascript" src="src/js/jquery.min.js"></script>
<script type="text/javascript" src="src/js/extended.js"></script>
<script type="text/javascript" src="src/js/mobile_menu.js"></script>
<script>
    const contact_email = "<?php echo $contact_email ?>";

    $("#banner").ready(function () {
        $('.fade-in-onload').each(function () {
            $(this).addClass('is-visible');
        });
    });

    $(window).ready(async function () {
        const done = await loadMembers();
        const emailComp = document.getElementById("contact-email");
        if (emailComp) {
            emailComp.innerHTML = contact_email;
        }
        if (done) {
            $('.fade-in').each(function () {
                const top_of_element = $(this).offset().top;
                const bottom_of_element = $(this).offset().top + $(this).outerHeight();
                const bottom_of_screen = $(window).scrollTop() + $(window).innerHeight();
                const top_of_screen = $(window).scrollTop();

                if ((bottom_of_screen > top_of_element) && (top_of_screen < bottom_of_element) && !$(this).hasClass('is-visible')) {
                    $(this).addClass('is-visible');
                }
            });
        }
    });

    $(window).ready(function () {
        $('.fade-in').each(function () {
            const top_of_element = $(this).offset().top;
            const bottom_of_element = $(this).offset().top + $(this).outerHeight();
            const bottom_of_screen = $(window).scrollTop() + $(window).innerHeight();
            const top_of_screen = $(window).scrollTop();

            if ((bottom_of_screen > top_of_element) && (top_of_screen < bottom_of_element) && !$(this).hasClass('is-visible')) {
                $(this).addClass('is-visible');
            }
        });
    });

    $(window).scroll(function () {
        $('.fade-in').each(function () {
            const top_of_element = $(this).offset().top;
            const bottom_of_element = $(this).offset().top + $(this).outerHeight();
            const bottom_of_screen = $(window).scrollTop() + $(window).innerHeight();
            const top_of_screen = $(window).scrollTop();

            if ((bottom_of_screen > top_of_element) && (top_of_screen < bottom_of_element) && !$(this).hasClass('is-visible')) {
                $(this).addClass('is-visible');
            }
        });
    });

    document.addEventListener("DOMContentLoaded", () => {
        var lazyVideos = [].slice.call(document.querySelectorAll("video.lazy"));

        if ("IntersectionObserver" in window) {
            var lazyVideoObserver = new IntersectionObserver(function (entries, observer) {
                entries.forEach(function (video) {
                    if (video.isIntersecting) {
                        for (var source in video.target.children) {
                            var videoSource = video.target.children[source];
                            if (typeof videoSource.tagName === "string" && videoSource.tagName === "SOURCE") {
                                videoSource.src = '<?php echo $about_video ?>';
                            }
                        }

                        video.target.load();
                        video.target.classList.remove("lazy");
                        lazyVideoObserver.unobserve(video.target);
                    }
                });
            });

            lazyVideos.forEach(function (lazyVideo) {
                lazyVideoObserver.observe(lazyVideo);
            });
        }
    });
    
</script>

</html>