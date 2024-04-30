<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>5e NPC Gen</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sedan:ital@0;1&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" href="style.css" />
</head>
<body>
        <img src="images/favicon.ico" alt="5e NPC Generator" id="logo">
        <h1><span style="font-size:6rem; color: #db001c">5</span><span style="color: #db001c">e</span> NPC Generator</h1>
        <p id="powered">Powered by <span style="font-weight: bold; color: #74aa9c">ChatGPT</span> & <span style="font-weight: bold; color: #74aa9c">DALL-E</span> <a href="https://chat.openai.com" target="blank"><img src="images/gpt-icon.png" style="height: 20pt"></a></p>
        <p id="details">The more details you provide, the more specific the result will be. Leave it empty for a completely random character.</p>
        <div id="form">
            <input type="text" placeholder="Enter a description for your NPC" id="prompt" autocomplete="off">
            <ul class="dropdown">
                <li id="selected"><span class="divider" style="font-weight: bold">˅&nbsp;&nbsp;&nbsp;</span> Digital Illustration</li>
                <ul class="dropdown-content hidden">
                    <li><input type="radio" name="imagesnum" id="r1" checked value=1><label for="r1">Digital Illustration</label></li>
                    <li><input type="radio" name="imagesnum" id="r2" value=2><label for="r2">Photorealistic Rendering</label></li>
                    <li><input type="radio" name="imagesnum" id="r3" value=3><label for="r3">Concept Art</label></li>
                    <li><input type="radio" name="imagesnum" id="r4" value=4><label for="r4">Watercolor</label></li>
                    <li><input type="radio" name="imagesnum" id="r5" value=5><label for="r5">Oil Painting</label></li>
                    <li><input type="radio" name="imagesnum" id="r6" value=6><label for="r6">Ink Drawing</label></li>
                    <li><input type="radio" name="imagesnum" id="r7" value=7><label for="r7">Octane Render</label></li>
                    <li><input type="radio" name="imagesnum" id="r8" value=8><label for="r8">Isometric</label></li>
                    <li><input type="radio" name="imagesnum" id="r9" value=9><label for="r9">Pixel Art</label></li>
                </ul>
            </ul>
            <button id="send"><img src="images/d20.png" alt=""></button>
        </div>

        <p id="disclaimer">ChatGPT can make mistakes. Please check any necessary information before using it</p>

        <!--Output will be displayed here-->
        <div id="card">
            <p id="copy-btn"><img src="images/copy-icon.png" /></p>
            <img src="images/barn_barlin.png" alt="Barn Barlin, The Bard" id="image">
            <div id="info-card">
                <p id="name">Barn Barlin, <span class="epi-class">The Bard</span></p>
                <p id="race">Tiefling</p>
                <p id="description">Barn Barlin stands out with crimson skin, large curled horns, and a charming smile. He is always carrying his ornately decorated lyre, ready to enchant and mesmerize his audience with his music and poetry.</p>
                <p id="background">Barlin hails from a long line of tiefling bards known for their exceptional talent in storytelling and music. He grew up learning the art of performance from his family and set out on his own to travel the land, seeking adventure and inspiration for his songs.</p>
                <div id="stat_block">
                    <p class="stats"><span class="skill">STR</span><span class="score" id="str">10</span></p>
                    <p class="stats"><span class="skill">DEX</span><span class="score" id="dex">14</span></p>
                    <p class="stats"><span class="skill">CON</span><span class="score" id="con">12</span></p>
                    <p class="stats"><span class="skill">INT</span><span class="score" id="int">16</span></p>
                    <p class="stats"><span class="skill">WIS</span><span class="score" id="wis">8</span></p>
                    <p class="stats"><span class="skill">CHA</span><span class="score" id="cha">18</span></p>    
                </div>
                <p id="closest_monster"><span id="fixed">Official stat block:</span> Bard</p>
            </div>
        </div>
        <!--Skeleton for the card-->
        <div id="card-skeleton">
            <div id="image-skeleton"></div>
            <div id="info-card-skeleton">
                <div id="name-skeleton"></div>
                <div id="race-skeleton"></div>
                <hr />
                <div id="description-skeleton">
                    <div class="line-skeleton"></div>
                    <div class="line-skeleton"></div>
                    <div class="line-skeleton"></div>
                    <div class="line-skeleton"></div>
                    <div class="line-skeleton"></div>
                </div>
                <div id="stats-skeleton">
                    <div class="box-skeleton"></div>
                    <div class="box-skeleton"></div>
                    <div class="box-skeleton"></div>
                    <div class="box-skeleton"></div>
                    <div class="box-skeleton"></div>
                    <div class="box-skeleton"></div>
                </div>
                <div class="last-line"></div>
            </div>
        </div>
        <div id="footer"><span id="info1"><b>Disclaimer:</b> This app is not affiliated with OpenAI, Wizards of the Coast, Dungeons & Dragons, or any of their products.</span><span id="info2">Created with ❤️ for the game by <a href="https://arkonique.github.io" target="blank">@arkonique</a></span><span id="info3"><a href="https://ko-fi.com/arkonique"><img src="images/kofi_s_tag_white.png"></a></span</div>

    </body>
    <script src="script.js"></script>
</html>