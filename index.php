<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<head>
  <title>Sherpa - Pathway Home</title>
</head>
<body style="display: none">
<style>
    * {
  box-sizing: border-box;
}

body {
  font: 16px Arial;  
}

/*the container must be positioned relative:*/
.autocomplete {
  position: relative;
  display: inline-block;
      width: 80%;
}

input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}

input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}

input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
  cursor: pointer;
  width: 19%;
}

.autocomplete-items {
   position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
#hidden {
    display: none;
}
.autocomplete {
    position: relative;
  display: inline-block;
}
.container {
        margin: auto;
    max-width: 500px;
    width: 100%;
}
.logo {
    text-align: center;
}
.logo img {
    width: 300px;
}
</style>
<div class="container">
    <div class='logo'>
<img src="img/sherpa-logo.svg">
</div>
<form autocomplete="off" id="form" action="/search" method="post">
    <div class="autocomplete">
  <input id="input" type="text" placeholder="Start Typing Class Name" name="input">
  </div>
  <input type="submit" value="Search" name="submit">
</form>
<p>Classes Entered</p>
<ul id="classes"></ul>
</div>
<script>
var counter = 0;
let classesEntered = [];
function autocomplete(inp, arr) {
  var currentFocus;
  inp.addEventListener("input", function(e) {
  var btn = document.getElementById('btn');
  var form = document.getElementById('form');
  var addInput = function() {
    counter++;
    var input = document.createElement("input");
    input.id = 'hidden';
    input.type = 'text';
    input.name = counter;
    input.value = document.getElementById("input").value;
    form.appendChild(input);
  };
  var updateList = function(){
      let list = document.getElementById("classes");
      let li = document.createElement("li");
      li.innerText = classesEntered[classesEntered.length -1];
      list.appendChild(li);
  };
      var a, b, i, val = this.value;
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      this.parentNode.appendChild(a);
      for (i = 0; i < arr.length; i++) {
        if (arr[i]['name'].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          b = document.createElement("DIV");
          b.innerHTML = "<strong>" + arr[i]['name'].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i]['name'].substr(val.length);
          b.innerHTML += "<input type='hidden' alt='"+ arr[i]['name'] +"' value='" + arr[i]['id'] + "'>";
          b.addEventListener("click", function(e) {
              inp.value = this.getElementsByTagName("input")[0].value;
              addInput();
              closeAllLists();
              document.getElementById("input").value = null;
            inp.name = this.getElementsByTagName("input")[0].alt;
              classesEntered.push(inp.name);
              updateList();
          });
          a.appendChild(b);
        }
      }
  });
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        currentFocus++;
        addActive(x);
      } else if (e.keyCode == 38) { //up
        currentFocus--;
        addActive(x);
      } else if (e.keyCode == 13) {
        e.preventDefault();
        if (currentFocus > -1) {
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    if (!x) return false;
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

var data = `
[
    {
      "id": "1-1",
      "name": "Audio/Video Production I"
    },
    {
      "id": "2-1",
      "name": "Audio/Video Production II"
    },
    {
      "id": "3-2",
      "name": "Broadcast Production (Broadcasting Technology)"
    },
    {
      "id": "4-1",
      "name": "Filmmaking (Audio/Video Production III)"
    },
    {
      "id": "5-1",
      "name": "Film Studies"
    },
    {
      "id": "6-2",
      "name": "Television Production"
    },
    {
      "id": "7-1",
      "name": "Academy Capstone"
    },
    {
      "id": "8-1",
      "name": "Capstone: Digital Media & Communication"
    },
    {
      "id": "9-1",
      "name": "Commercial Photography I"
    },
    {
      "id": "10-1",
      "name": "Commercial Photography II"
    },
    {
      "id": "11-1",
      "name": "Graphic Design & Illustration I (Intro to Graphic Design)"
    },
    {
      "id": "12-1",
      "name": "Introduction to Business"
    },
    {
      "id": "13-1",
      "name": "Marketing Principles"
    },
    {
      "id": "14-1",
      "name": "Performing & Communications A (Drama - Acting/Performance)"
    },
    {
      "id": "15-1",
      "name": "Photography (Intro - Adv.)"
    },
    {
      "id": "16-1",
      "name": "Public Speaking"
    },
    {
      "id": "17-2",
      "name": "Technical Theatre A (Stagecraft)"
    }
  ]`;

var classes = JSON.parse(data);

autocomplete(document.getElementById("input"), classes);
    document.getElementsByTagName('body')[0].style = 'display: block';
</script>

</body>
</html>
