<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// 🔐 Replace this with your actual OpenAI API key
$apiKey = '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';

// ✅ Step 1: Check if the message is set
if (!isset($_GET['message']) || empty(trim($_GET['message']))) {
    echo json_encode(["error" => "Missing or empty message"]);
    exit;
}

$userMessage = trim($_GET['message']);

// ✅ Step 2: Build the prompt
$prompt = "
You are a smart assistant for a clinic app.

Only use one of the following intents:
- book_appointment
- view_appointments
- cancel_appointment
- get_clinic_hours

Return a JSON object like:
{
  \"intent\": \"book_appointment\",
  \"specialty\": \"dentist\",
  \"date\": \"2025-04-01\",
  \"time\": \"10:00\"
}

User input: \"$userMessage\"
";

// ✅ Step 3: Prepare OpenAI request
$data = [
    "model" => "gpt-3.5-turbo",
    "messages" => [
        ["role" => "user", "content" => $prompt]
    ],
    "temperature" => 0.5,
    "max_tokens" => 150
];

// ✅ Step 4: Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


// ✅ Step 5: Execute request
$response = curl_exec($ch);

// ✅ Step 6: Handle cURL errors
if (curl_errno($ch)) {
    echo json_encode(["error" => curl_error($ch)]);
    curl_close($ch);
    exit;
}

curl_close($ch);

// ✅ Step 7: Decode response
$responseData = json_decode($response, true);

echo "<pre>";
print_r($response);
echo "</pre>";
exit;


// ✅ Step 8: Extract and return result
if (isset($responseData['choices'][0]['message']['content'])) {
    $output = trim($responseData['choices'][0]['message']['content']);
    echo $output;
} else {
    echo json_encode(["error" => "Invalid response from OpenAI"]);
}
