<?php
/**
 *  @Created By fsl
 *  @Time:2012-07-20 03:50:23
 */
 global $apiConfig;
$apiConfig =array (
  'use_objects' => false,
  'application_name' => 'openbiz',
  'oauth2_client_id' => '632901462778-vcc47015v7nl6qg1cpt9qcmd3kbuiqp5.apps.googleusercontent.com',
  'oauth2_client_secret' => '0-NcMk2IwQlyHdHysxzuzjjG',
  'oauth2_redirect_uri' => 'http://local.openbiz.me/oauth_callback_handler.php?type=google&service=CallBack',
  'developer_key' => '',
  'oauth_consumer_key' => 'anonymous',
  'oauth_consumer_secret' => 'anonymous',
  'site_name' => 'www.example.org',
  'authClass' => 'apiOAuth2',
  'ioClass' => 'apiCurlIO',
  'cacheClass' => 'apiFileCache',
  'oauth_test_token' => '',
  'oauth_test_user' => '',
  'basePath' => 'https://www.googleapis.com',
  'ioFileCache_directory' => 'h:\\temp/apiClient',
  'ioMemCacheStorage_host' => '127.0.0.1',
  'ioMemcacheStorage_port' => '11211',
  'services' => 
  array (
    'analytics' => 
    array (
      'scope' => 'https://www.googleapis.com/auth/analytics.readonly',
    ),
    'calendar' => 
    array (
      'scope' => 
      array (
        0 => 'https://www.googleapis.com/auth/calendar',
        1 => 'https://www.googleapis.com/auth/calendar.readonly',
      ),
    ),
    'books' => 
    array (
      'scope' => 'https://www.googleapis.com/auth/books',
    ),
    'latitude' => 
    array (
      'scope' => 
      array (
        0 => 'https://www.googleapis.com/auth/latitude.all.best',
        1 => 'https://www.googleapis.com/auth/latitude.all.city',
      ),
    ),
    'moderator' => 
    array (
      'scope' => 'https://www.googleapis.com/auth/moderator',
    ),
    'oauth2' => 
    array (
      'scope' => 
      array (
        0 => 'https://www.googleapis.com/auth/userinfo.profile',
        1 => 'https://www.googleapis.com/auth/userinfo.email',
      ),
    ),
    'plus' => 
    array (
      'scope' => 'https://www.googleapis.com/auth/plus.me',
    ),
    'siteVerification' => 
    array (
      'scope' => 'https://www.googleapis.com/auth/siteverification',
    ),
    'tasks' => 
    array (
      'scope' => 'https://www.googleapis.com/auth/tasks',
    ),
    'urlshortener' => 
    array (
      'scope' => 'https://www.googleapis.com/auth/urlshortener',
    ),
  ),
);

?>