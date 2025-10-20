<?php
// lib/CaptchaVerifier.php
namespace lib;
class CaptchaVerifier
{
  private $config;

  public function __construct(array $config)
  {
    $this->config = $config;
  }

  // kiểm tra dựa trên provider được cấu hình
  public function verify(array $postData, string $remoteIp = null): bool
  {
    $provider = $this->config['provider'] ?? 'google';

    if ($provider === 'turnstile') {
      $token = $postData['cf-turnstile-response'] ?? null;
      if (!$token) return false;
      return $this->verifyTurnstile($token, $remoteIp);
    } else {
      // Google reCAPTCHA v2: token field name is g-recaptcha-response
      $token = $postData['g-recaptcha-response'] ?? null;
      if (!$token) return false;
      return $this->verifyRecaptcha($token, $remoteIp);
    }
  }

  private function verifyRecaptcha(string $token, ?string $remoteIp = null): bool
  {
    $secret = $this->config['google_secret_key'] ?? '';
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = http_build_query([
      'secret' => $secret,
      'response' => $token,
      'remoteip' => $remoteIp,
    ]);

    $opts = ['http' => [
      'method' => 'POST',
      'header' => "Content-type: application/x-www-form-urlencoded\r\n",
      'content' => $data
    ]];
    $context = stream_context_create($opts);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) return false;
    $json = json_decode($result, true);
    // $json['success'] true khi hợp lệ
    return isset($json['success']) && $json['success'] === true;
  }

  private function verifyTurnstile(string $token, ?string $remoteIp = null): bool
  {
    $secret = $this->config['turnstile_secret_key'] ?? '';
    $url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

    $data = http_build_query([
      'secret' => $secret,
      'response' => $token,
      'remoteip' => $remoteIp,
    ]);

    $opts = ['http' => [
      'method' => 'POST',
      'header' => "Content-type: application/x-www-form-urlencoded\r\n",
      'content' => $data
    ]];
    $context = stream_context_create($opts);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) return false;
    $json = json_decode($result, true);
    // Turnstile trả về success boolean
    return isset($json['success']) && $json['success'] === true;
  }
}
