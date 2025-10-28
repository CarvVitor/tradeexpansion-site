<?php
if (!defined('ABSPATH')) {
  exit;
}

if (!function_exists('tec_portal_user_has_financial') || !tec_portal_user_has_financial(get_current_user_id())) {
  return;
}
