<?php
require_once '../config.php';

class GitHubLib
{
    public static function getContents(string $path)
    {
        $response = GitHubLib::__curl('/repos/' . Config::$GITHUB_USERNAME . '/' . Config::$GITHUB_REPOSITORY . '/contents/' . urlencode($path), null);
        return $response;
    }

    public static function __curl(string $url, $data)
    {
        if (!str_starts_with($url, '/'))
            $url = '/' . $url;

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, Config::$GITHUB_API_BASE_URL . $url);
        if (isset($data) && is_object($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_USERAGENT, 'SMAN3PLW');
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            sprintf('Authorization: token %s', Config::$GITHUB_TOKEN),
            'X-GitHub-Api-Version: 2022-11-28',
            'Content-Type: application/json',
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
        if (curl_errno($curl)) {
            return ['error' => curl_error($curl)];
        }

        curl_close($curl);

        return json_decode($result);
    }
}