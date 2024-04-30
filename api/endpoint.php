<?php
header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

$api_key = getenv('OPENAI_API_KEY');
$url = 'https://api.openai.com/v1/chat/completions';

$requestData = [
    'model' => 'gpt-3.5-turbo',
    'response_format' => ['type' => 'json_object'],
    'max_tokens' => 256,
    'temperature' => 1.4,
    'top_p' => 1,
    'frequency_penalty' => 0,
    'presence_penalty' => 0,
    'messages' => [
        [
            'role' => 'system',
            'content' => 'You are a writer for the Dungeons and Dragons game tasked to create NPCs in JSON format. You need to include a first name, a last name, an epithet, a race, a description, a background, a stat block, and the closest monster stat block name from official source books.'
        ],
        [
            'role' => 'user',
            'content' => $data['prompt']
            ]
            ]
        ];
$ch = curl_init($url);
        
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key
]);

$response = curl_exec($ch);
/*        

if (curl_errno($ch)) {
    //echo json_encode(['error' => curl_error($ch)]);
} else {
    //echo $response;
}

*/
$r = json_decode($response, true);
$r2 = json_encode($r['choices'][0]['message']['content']);
$r3 = json_decode(json_decode($r2,true),true);
curl_close($ch);
?>

<?php
// Second request to match the generated json to some standardised format of a json which contains fields "fname","lname","epithet","race","desc","backg","statb","cmonst"
$requestData = [
    'model' => 'gpt-3.5-turbo',
    'response_format' => ['type' => 'json_object'],
    'max_tokens' => 256,
    'temperature' => 0,
    'top_p' => 1,
    'frequency_penalty' => 0,
    'presence_penalty' => 0,
    'messages' => [
        [
            'role' => 'system',
            'content' => 'You are a debugger who looks at json with incorrectly named fields and corrects it based on this schema -\n{\"$schema\": \"http://json-schema.org/draft-04/schema#\",\"type\": \"object\",\"properties\": {\"first_name\": {\"type\": \"string\"},\"last_name\": {\"type\": \"string\"},\"epithet\": {\"type\": \"string\"},\"race\": {\"type\": \"string\"},\"description\": {\"type\": \"string\"},\"background\": {\"type\": \"string\"},\"stat_block\": {\"type\": \"object\",\"properties\": {\"STR\": {\"type\": \"integer\"},\"DEX\": {\"type\": \"integer\"},\"CON\": {\"type\": \"integer\"},\"INT\": {\"type\": \"integer\"},\"WIS\": {\"type\": \"integer\"},\"CHA\": {\"type\": \"integer\"}},\"required\": [\"STR\",\"DEX\",\"CON\",\"INT\",\"WIS\",\"CHA\"]},\"closest_monster\": {\"type\": \"string\"}},\"required\": [\"first_name\",\"last_name\",\"epithet\",\"race\",\"description\",\"background\",\"stat_block\",\"closest_monster\"]}'
        ],
        [
            'role' => 'user',
            'content' => json_decode($r2,true)
        ]
    ]
];

$ch = curl_init($url);
        
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key
]);

$response = curl_exec($ch);

$r = json_decode($response, true);
$r2 = json_encode($r['choices'][0]['message']['content']);
$r3 = json_decode(json_decode($r2,true),true);

curl_close($ch);

?>

<?php
// Third request to generate images of the generated NPC

$url = 'https://api.openai.com/v1/images/generations';

$promptString = "Generate a " . $data['style'] . " of " . $r3["first_name"] . " " . $r3["last_name"] . ", " . $r3["epithet"] . ". " . $r3["description"]. ". " . $r3["background"] . ". Should have a blank background.";

$requestData = [
    'model' => "dall-e-3",
    'prompt' => $promptString,
    "size" => "1024x1024"
];

$ch = curl_init($url);
        
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key
]);

$response = curl_exec($ch);

$r = json_decode($response, true);
$r3['image'] = $r['data'][0]['url'];
$r3['prompt'] = $r['data'][0]['revised_prompt'];

curl_close($ch);
echo json_encode($r3);
?>