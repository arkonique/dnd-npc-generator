// Code to interact with the API endpoint
const submit = document.querySelector("#send");
let jsonData = {
  "first_name": "Barn",
  "last_name": "Barlin",
  "epithet": "the Bard",
  "race": "Tiefling",
  "description": "Barn Barlin stands out with crimson skin, large curled horns, and a charming smile. He is always carrying his ornately decorated lyre, ready to enchant and mesmerize his audience with his music and poetry.",
  "background": "Barlin hails from a long line of tiefling bards known for their exceptional talent in storytelling and music. He grew up learning the art of performance from his family and set out on his own to travel the land, seeking adventure and inspiration for his songs.",
  "stat_block": {
    "STR": 10,
    "DEX": 14,
    "CON": 12,
    "INT": 16,
    "WIS": 8,
    "CHA": 18
  },
  "closest_monster": "Bard"
};
submit.addEventListener("click", () => {
  const artDict = {
    1: "digital illustration",
    2: "photorealistic rendering",
    3: "concept art style",
    4: "watercolor painting",
    5: "oil painting",
    6: "pen and ink drawing",
    7: "octane rendering",
    8: "isometric art",
    9: "pixel art"
  }
  const prompt = document.querySelector("#prompt").value;
  const num = document.querySelector('input[name="imagesnum"]:checked').value;
  const style = artDict[num];


  // hide the card and show the skeleton loader (card vs card-skeleton) by reducing the opacity of the card and increasing the opacity of the skeleton loader
  document.getElementById('card').style.opacity = 0;
  document.getElementById('card-skeleton').style.display = "flex";
  document.getElementById('card-skeleton').style.opacity = 1;
// Disable the button while the data is being fetched
  submit.style.pointerEvents = "none";
  submit.style.backgroundColor = "#ccc";


  // send this data to the api endpoint through a POST request
  fetch("/api/endpoint.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ prompt: prompt, style: style }),
  }).then((response) => {
    // do something with the response
    response.json().then((data) => {
      const fName = data["first_name"];
      const lName = data["last_name"];
      const epithet = data["epithet"];
      const race = data["race"];
      const desc = data["description"];
      const img = data["image"];
      const background = data["background"];
      const stat = data["stat_block"];
      const closest = data["closest_monster"];

      jsonData = data;
      console.log(data);

      document.querySelector("#name").innerHTML = `${fName} ${lName}, <span class="epi-class">${epithet}</span>`;
      document.querySelector("#race").textContent = race;
      document.querySelector("#description").textContent = desc;
      document.querySelector("#background").textContent = background;
      document.querySelector("#closest_monster").innerHTML = '<span id="fixed">Official stat block:</span> '+closest;
      document.querySelector("#image").src = img;
      document.querySelector("#image").alt = `${data["prompt"]}`;

      document.querySelector("#str").textContent = stat["STR"];
      document.querySelector("#dex").textContent = stat["DEX"];
      document.querySelector("#con").textContent = stat["CON"];
      document.querySelector("#int").textContent = stat["INT"];
      document.querySelector("#wis").textContent = stat["WIS"];
      document.querySelector("#cha").textContent = stat["CHA"];

      // once all the data is loaded, hide the skeleton loader and show the card by 1. Decreasing the opacity of the skeleton loader, waiting 0.3s for that to finish, then hiding the skeleton loader and showing the card
      // Disable the button while the data is being fetched
      submit.style.pointerEvents = "";
      submit.style.backgroundColor = "";
      document.getElementById('card-skeleton').style.opacity = 0;
      setTimeout(() => {
        document.getElementById('card-skeleton').style.display = "none";
        document.getElementById('card').style.opacity = 1;
      }, 300);

    });
  });
});

// Dropdown menu
const selected = document.querySelector(".dropdown");

selected.addEventListener("click", () => {
  const dropdown = document.querySelector(".dropdown-content");
  dropdown.classList.toggle("hidden");

});

// Close the dropdown menu if the user clicks outside of it and it is open

window.addEventListener("click", (event) => {
  const dropdown = document.querySelector(".dropdown-content");
  if (!event.target.matches("#selected")) {
    if (!dropdown.classList.contains("hidden")) {
      dropdown.classList.add("hidden");
    }
  }
});

// Change the selected value when the user clicks on an option
const options = document.querySelectorAll("label");

options.forEach((option) => {
  option.addEventListener("click", () => {
    const selected = document.querySelector("#selected");
    selected.innerHTML = '<span class="divider" style="font-weight: bold">˅&nbsp;&nbsp;&nbsp;</span>'+option.textContent;
  });
});

// Card hover effect
document.getElementById('card').addEventListener('mousemove', function(e) {
  const rect = this.getBoundingClientRect();  // Get the position and size of the card
  const x = e.clientX - rect.left;  // X position within the element
  const y = e.clientY - rect.top;  // Y position within the element

  const centerX = rect.width / 2;
  const centerY = rect.height / 2;

  // Calculate rotation angle: Subtract the center positions to center the effect on the card
  const rotateX = (centerY - y) / 200;  // Dividing to reduce the effect
  const rotateY = (x - centerX) / 600;

  this.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
});

// Reset rotation when mouse leaves the card
document.getElementById('card').addEventListener('mouseleave', function() {
  this.style.transform = 'rotateX(0deg) rotateY(0deg)';
});


// Copy jsonData on clicking #copy-btn
document.getElementById('copy-btn').addEventListener('click', () => {
  navigator.clipboard.writeText(JSON.stringify(jsonData, null, 2));
});
