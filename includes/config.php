<?php
/*
 * i.e. /home/dynamoelectric/public_html/project.rock
 */
define("ROOT", $_SERVER['DOCUMENT_ROOT']."/public_html/");
define("BACKEND", ROOT."rock_backend/");
define("B_ASSETS" , "../rock_backend/backend_assets/");
define("DATE_ADDED", date("F j,Y, g:i a"));
define("BE_CSS", B_ASSETS."css/");
define("BE_JS", B_ASSETS."js/");
define("BE_FONTS", B_ASSETS."fonts/");
define("BE_IMAGES", B_ASSETS."images/");
define("PROJECT_NAME", "project_rock");
define("PROJECT_URL", "http://project.rock.webulence.com");
define("ADMIN_PASS", "616812d7a966392405fdf0b166c377a0");
define("CUSTOMER", "The Line");
/*
 * DB INFO
 */
define("DB_USERNAME", "projectrockAdmin");
define("DB_PASSWORD", "ProjectRock123#");
define("DB_NAME", "project_rock");
define("DB_HOST", "localhost");

/*
 * Fornt End
 */
define("URL", "project.rock.webulence.com/public_html/");
define("FRONTEND", "rock_frontend");
define("F_ASSETS", FRONTEND."/frontend_assets/");
define("FE_IMAGES", ROOT.F_ASSETS."images/");
define("IMAGE_PATH", "../rock_frontend/frontend_assets/images/");
define("P_IMAGE_PATH", "/rock_frontend/frontend_assets/images/");

define("FE_FILES", F_ASSETS."files/");
define("FILE_PATH", "../rock_frontend/frontend_assets/files/");