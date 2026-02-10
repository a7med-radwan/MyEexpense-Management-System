<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl =
        'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-001:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
    }

    public function generatePlan($currentData)
    {
        if (!$this->apiKey) {
            Log::error('Gemini API Key is missing. Check your .env and config/services.php');
            return null;
        }

        $prompt = "بصفتك خبير استشارات مالية، قم بتحليل البيانات التالية لتقديم ميزانية ذكية ومنطقية:
        
        البيانات الحالية للشهر:
        - إجمالي الدخل: {$currentData['income']} ر.س
        - التصنيفات الحالية (الاسم، الميزانية المحددة، المبلغ المصروف فعلياً): " . json_encode($currentData['categories'], JSON_UNESCAPED_UNICODE) . "
        
        المطلوب منك تحليل 'الفارق' بين الميزانية والمصروف الفعلي:
        1. إذا كان المستخدم يتجاوز الميزانية في تصنيف معين، اقترح مبلغاً واقعياً بناءً على صرفه الفعلي مع نصيحة للتقليل.
        2. إذا كان هناك وفر في تصنيف معين، اقترح تحويل جزء منه للادخار أو لتغطية عجز في تصنيف آخر.
        3. تأكد أن مجموع الميزانية المقترحة لا يتجاوز إجمالي الدخل بأي حال من الأحوال.
        4. اجعل 'سبب الاقتراح' (reason) احترافياً ومقنعاً ومرتبطاً بالأرقام المذكورة.

        يجب أن تكون الاستجابة بصيغة JSON فقط مصفوفة كائنات كالتالي:
        [
            {\"name\": \"اسم التصنيف\", \"suggested_amount\": 00.00, \"reason\": \"تحليل مالي منطقي مبني على الأرقام\"}
        ]
        لا تكتب أي شيء خارج المصفوفة.";
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '?key=' . $this->apiKey, [
                        'contents' => [
                            [
                                'role' => 'user',
                                'parts' => [
                                    ['text' => $prompt]
                                ]
                            ]
                        ],
                        'generationConfig' => [
                            'temperature' => 0.2,
                            'maxOutputTokens' => 1024,
                        ]
                    ]);


            Log::info('Gemini Raw Response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);


            if ($response->successful()) {
                $result = $response->json();
                $content = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;

                if ($content) {
                    $content = trim($content);
                    $content = str_replace(['```json', '```', 'json'], '', $content);
                    $decoded = json_decode(trim($content), true);

                    if (json_last_error() === JSON_ERROR_NONE) {
                        return $decoded;
                    }
                    Log::error('Gemini JSON Decode Error: ' . json_last_error_msg() . ' Content: ' . $content);
                }

                Log::error('Gemini Response Content missing: ' . json_encode($result));
                return null;
            } else {
                Log::error('Gemini API Error: ' . $response->status() . ' - ' . $response->body());
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Gemini Exception: ' . $e->getMessage());
            return null;
        }
    }
}
