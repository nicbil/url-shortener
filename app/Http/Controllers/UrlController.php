<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UrlController extends Controller
{
    public function addUrl(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

       $originalUrl = $request->input('url');

       if ($this->checkExistingOriginalUrl($originalUrl)) {
            return response()->json(['url' => $originalUrl, 'message' => 'Url already exist!']);
       } else {
            $shortenedUrl = $this->generateShortenedUrl();
            $insertUrlResult = $this->insertUrl($originalUrl, $shortenedUrl);

            if ($insertUrlResult) {
                return response()->json($insertUrlResult);
            }
       }
    }

    private function checkExistingOriginalUrl($originalUrl) {
        return DB::table('shortened_urls')->where('original_url', $originalUrl)->first();
    }

    private function checkExistingShortenedUrl($shortenedUrl) {
        return DB::table('shortened_urls')->where('shortened_url', $shortenedUrl)->first();
    }

    private function insertUrl($originalUrl, $shortenedUrl) {
        $id = DB::table('shortened_urls')->insertGetId(['original_url' => $originalUrl, 'shortened_url' => $shortenedUrl]);
        return DB::table('shortened_urls')->find($id);
    }

    private function generateShortenedUrl()
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length = 6;
        $shortenedUrl = '';

        for ($i = 0; $i < $length; $i++) {
            $shortenedUrl .= $chars[rand(0, strlen($chars) - 1)];
        }

        if ($this->checkExistingShortenedUrl($shortenedUrl)) {
            return $this->generateShortenedUrl();
        }

        return $shortenedUrl;
    }

    private function checkUrlSafety($url)
    {
        $apiKey = 'YOUR_API_KEY';
        $url = 'https://safebrowsing.googleapis.com/v4/threatMatches:find?key=' . $apiKey;

        $threatInfo = [
            'threatTypes' => ['MALWARE', 'SOCIAL_ENGINEERING', 'THREAT_TYPE_UNSPECIFIED'],
            'platformTypes' => ['ANY_PLATFORM'],
            'threatEntryTypes' => ['URL'],
            'threatEntries' => [
                ['url' => 'http://example.com/']
            ]
        ];

        $data = [
            'client' => [
                'clientId' => 'yourcompany',
                'clientVersion' => '1.5.2'
            ],
            'threatInfo' => $threatInfo
        ];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ]
        ];

        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($response, true);

        if (isset($result['matches'])) {
            foreach ($result['matches'] as $match) {
                echo 'URL ' . $match['threat']['url'] . ' является опасным типом ' . $match['threatType'] . PHP_EOL;
            }
        } else {
            echo 'URL безопасен' . PHP_EOL;
        }
    }

    public function getShortenUrls() {
        return DB::table('shortened_urls')->get();
    }
}
