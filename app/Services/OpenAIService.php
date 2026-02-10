<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    protected $apiKey;
    protected $baseUrl = 'https://openrouter.ai/api/v1';

    public function __construct()
    {
        $this->apiKey = config('services.openai.key');
    }

    public function generatePlan($currentData)
    {
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
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'HTTP-Referer' => config('app.url'),
                'X-Title' => config('app.name'),
            ])->post($this->baseUrl . '/chat/completions', [
                        'model' => 'openai/gpt-4o-mini',
                        'messages' => [
                            ['role' => 'system', 'content' => 'أنت مستشار مالي ذكي، دقيق جداً في الحسابات، وتعطي نصائح منطقية مبنية على تحليل البيانات المالية الفعلية.'],
                            ['role' => 'user', 'content' => $prompt],
                        ],
                        'temperature' => 0.3,
                    ]);

            if ($response->successful()) {
                $content = $response->json('choices.0.message.content');
                // Clean up any potential markdown code blocks if GPT adds them
                $content = str_replace('```json', '', $content);
                $content = str_replace('```', '', $content);
                return json_decode(trim($content), true);
            } else {
                Log::error('OpenAI API Error: ' . $response->body());
                return null;
            }
        } catch (\Exception $e) {
            Log::error('OpenAI Exception: ' . $e->getMessage());
            return null;
        }
    }
}
