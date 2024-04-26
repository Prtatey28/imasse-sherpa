<!--Welcome to the code for the website, anything in green are comments. These will help explain what's going on-->
<!--This piece of code makes the entire code doc in HTML format-->
<!DOCTYPE html>
<!--Signifies start of HTML code-->
<html>
<!--This is the meta data for the website. It explains the scale and the ratios of the website-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--This is the "tab" name of the website. It will display in all of your tabs of your browser-->
<head>
  <link rel="icon" href="img/Sherpa_Logo2.png">
  <title>Sherpa - Pathway Home</title>
</head>
<!--This defines the body element, which includes every single element on the web page-->
<body style="display: none">
  <!--This is the start of the CSS for designing the website first page HTML uses CSS to understand how to "decorate" things with colors and sizes-->
  <style>
    * {
      box-sizing: border-box;
    }

    /*CSS for whole website page*/
    body {
      font: 16px Arial;
      background-color: white;
    }

    /*This is the CSS for the live search box of the website*/
    /*the container must be positioned relative:*/
    .autocomplete {
      position: relative;
      display: inline-block;
      width: 80%;
    }

    /*This is the CSS for the search box, it adjusts how big it is and the kind of text being inputted*/
    input {
      border: 1px solid transparent;
      padding: 10px;
      font-size: 16px;
    }

    /* This is also CSS for the search box. It adjusts color and size of it*/
    input[type=text] {
      background-color: #f1f1f1;
      width: 100%;
    }

    /*This is the CSS for the search button of the webpage*/
    input[type=submit] {
      background-color: dodgerblue;
      color: #fff;
      cursor: pointer;
      width: 19%;
    }

    /*This is the CSS for classes that are populated below when you type in certain letters or numbers*/
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

    /* These are additional properties for the populating classes below search bar as you type them in*/
    .autocomplete-items div {
      padding: 10px;
      cursor: pointer;
      background-color: #fff;
      border-bottom: 1px solid #d4d4d4;
    }

    /*when hovering an item: This will give the color it changes to from white*/
    .autocomplete-items div:hover {
      background-color: #e9e9e9;
    }

    /*when navigating through the items using the arrow keys: This will change the color of the highlighted portion*/
    .autocomplete-active {
      background-color: DodgerBlue !important;
      color: #ffffff;
    }

    #hidden {
      display: none;
    }

    /*adjusts position for search bar, populated search results, logo. Also adjusts logo size */
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
      width: 400px;
    }

    h1 {
      text-align: center;
      font-size: 45px;
    }

    .removeAllButton {
      cursor: pointer;
      padding: 5px;
      color: blue;
      text-decoration: underline;
      text-align: center;
      display: block;
      font-weight: 800;
      font-size: 15px;
    }

    .removeAllButton:hover {
      color: red;
    }

    .list-1 {
      padding: 5px;
    }

    .list-1-li {
      margin-bottom: 10px;
    }
  </style>
  <!--This is the end of the CSS portion of the Code -->
  <!--This piece of the code is all about making everything show up on the website. This is typical HTML-->
  <!--Title Header-->
  <!--This piece of the code places all of the elements on the website, based on their CSS location, size, and color-->
  <h1 style="background-color: #CCD1D1; color:black;"> Welcome to the: <span style="color:#CB4335">S</span>uper <span style="color:#CB4335">H</span>elpful <span style="color:#CB4335">E</span>asily <span style="color:#CB4335">R</span>eadable <span style="color:#CB4335">P</span>athway <span style="color:#CB4335">A</span>ssistant! </h1>
  <p style="position: bottom; text-align:center; font-size:30px;"><mark><b>NOTE:</b> Visit the <a href='https://docs.google.com/document/d/1Sb5T9UpqaVv87lefkwTaRzjJZBBoecEDOivG_zqZh9k/edit?usp=sharing' target="_blank"><b>Wiki</a></b> if you have issues! </mark></p>
  <div class="container">
    <div class='logo'>
      <a href="https://sites.google.com/view/pathwaypre-checkimprovement/home" target="_blank"><img src="img/Sherpa_Logo.png"></a>
    </div>
    <p style="position: bottom; text-align:center; font-size:20px;"><mark>Enter Your Classes Below, <b>BY SEMESTER,</b> and Press the Blue "Verify" Button When You Are Ready to Continue</mark></p>
    <p style="position: bottom; text-align:center; font-size:18px; background-color:pink;"><b><u>Keep In Mind:</u></b>
    <ul class="list-1">
      <li class="list-1-li"><mark>You are adding every single <b>PASSED</b> class from your highschool career so far, including the classes you are taking this semester</mark></li>
      <li class="list-1-li">Multiple year classes are subjugated by "I" not "#." (Ex: Algebra 2 = Algebra II.)</li>
      <li class="list-1-li">Math 4th year is its own class, make sure to add it if it applies to you!</li>
      <li class="list-1-li">Geometry in construction and AMPED are their own classes (Ex: Add AMPED, not AMPED + Algebra I)</li>
      <li class="list-1-li">Full list of available classes can be found <a href='https://docs.google.com/document/d/1DWIG5TPWUFKCGuHTxO5pViDzF1kx9RVS61CTlSSL4i0/edit?usp=sharing' target="_blank"><b>HERE</b></a></li>
    </ul>
    </p>
    <!--This code is what is run when the search button is pressed. The search bar is turned off, and it sends you to the next webpage, search.php-->
    <form autocomplete="off" id="form" action="/search.php" method="post">
      <div class="autocomplete">
        <!--This code is used to define what's inside the search bar-->
        <input id="input" type="text" placeholder="Start Typing Class Name" name="input">
      </div>
      <input type="submit" value="Verify" name="submit">
      <div id="hiddenInputs">
      </div>
    </form>
    <!--This code determines where the title "Classes entered" is located below the search bar-->
    <p style="background-color:#fff;text-align:center;font-size:18px"><b><u>Classes Entered</u></b></p>
    <ul id="classes"></ul>
    <a class="removeAllButton" id="removeAll">Click Here to Remove All Classes!</a>
  </div>
  <p style="text-align:left; font-size:15px;"><u><b>Questions? </u></b><br> Visit the <a href='https://docs.google.com/document/d/1Sb5T9UpqaVv87lefkwTaRzjJZBBoecEDOivG_zqZh9k/edit?usp=sharing' target="_blank">Wiki</p>
  <!--This is the JavaScript portion of the code. This is how the populating search bar works and and how selected classes are printed below-->
  <script>
    //grabs the php array from above and uses it here for the possible classes search bar
    //echo part of code adapted from https://www.geeksforgeeks.org/how-to-pass-a-php-array-to-a-javascript-function/#
    var data2 = <?php echo file_get_contents('json/allClasses.json'); ?>;
    var counter = 0;
    let classesEntered = [];
    var classID2 = [];
    var className2 = [];

    function removeClass(classID) {
      document.getElementById("input-" + classID).remove();
      document.getElementById("list-" + classID).remove();
      for (var i = 0; i < classID2.length; i++) {
        if (classID2[i] == classID) {
          classID2.splice(i, 1);
          var stringy = JSON.stringify(classID2);
          localStorage.setItem("classIDs", stringy);
        }
      }
      return false;
    }

    function autocomplete(inp, arr) {
      var currentFocus;
      inp.addEventListener("input", function(e) {
        var btn = document.getElementById('btn');
        var form = document.getElementById('hiddenInputs');
        var addInput = function() {
          counter++;
          var input = document.createElement("input");
          var classID = document.getElementById("input").value;
          input.id = "input-" + classID;
          input.type = 'hidden';
          input.name = counter;
          input.value = classID;
          form.appendChild(input);
          classID2.push(classID);
          var stringy = JSON.stringify(classID2);
          localStorage.setItem("classIDs", stringy);
        };
        var updateList = function(classID) {
          let list = document.getElementById("classes");
          let li = document.createElement("li");
          li.id = "list-" + classID;
          li.innerHTML = classesEntered[classesEntered.length - 1] + " " + "<a href=\"javascript:void(0);\" onClick='removeClass(\"" + classID + "\")'>Remove</a>";
          list.appendChild(li);
        };
        var a, b, i, val = this.value;
        closeAllLists();
        if (!val) {
          return false;
        }
        currentFocus = -1;
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        this.parentNode.appendChild(a);
        for (i = 0; i < arr.length; i++) {
          let matcher = new RegExp(escapeRegex(val), 'i');
          if (arr[i]['name'].match(matcher)) {
            b = document.createElement("DIV");
            b.innerHTML = arr[i]['name'].replace(matcher, "<strong>$&</strong>");
            b.innerHTML += "<input type='hidden' alt='" + arr[i]['name'] + "' value='" + arr[i]['id'] + "'>";
            b.addEventListener("click", function(e) {
              inp.value = this.getElementsByTagName("input")[0].value;
              var classID = inp.value;
              addInput();
              closeAllLists();
              document.getElementById("input").value = null;
              inp.name = this.getElementsByTagName("input")[0].alt;
              classesEntered.push(inp.name);
              updateList(classID);
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

      function escapeRegex(string) {
        return string.replace(/[/\-\\^$*+?.()|[\]{}]/g, '\\$&');
      }
      document.addEventListener("click", function(e) {
        closeAllLists(e.target);
      });
    }

    function form2(newClassIDs) {
      var btn = document.getElementById('btn');
      var form = document.getElementById('hiddenInputs');
      if (newClassIDs != null && newClassIDs.length > 0) {
        for (var i = 0; i < newClassIDs.length; i++) {
          counter++;
          var input = document.createElement("input");
          input.id = "input-" + newClassIDs[i];
          input.type = 'hidden';
          input.name = counter;
          input.value = newClassIDs[i];
          form.appendChild(input);
          classID2.push(newClassIDs[i]);
          var stringy = JSON.stringify(classID2);
          localStorage.setItem("classIDs", stringy);
          let list = document.getElementById("classes");
          let li = document.createElement("li");
          for (var j = 0; j < data2.length; j++) {
            if (data2[j].id == newClassIDs[i]) {
              classesEntered.push(data2[j].name);
            }
          }
          li.id = "list-" + newClassIDs[i];
          li.innerHTML = classesEntered[classesEntered.length - 1] + " " + "<a href=\"javascript:void(0);\" onClick='removeClass(\"" + newClassIDs[i] + "\")'>Remove</a>";
          list.appendChild(li);
        }
      }
    }

    function pushOldClasses() {
      var returnStringy = localStorage.getItem("classIDs");
      var newClassIDs = JSON.parse(returnStringy);
      form2(newClassIDs);
    }

    function removeAll() {
      classesEntered = [];
      document.getElementById('classes').innerHTML = '';
      document.getElementById('hiddenInputs').innerHTML = '';
      localStorage.clear();
    }
    //grabbing classes from allClasses.json and sending them into the search bar here
    document.addEventListener('DOMContentLoaded', pushOldClasses);
    autocomplete(document.getElementById("input"), data2);
    document.getElementsByTagName('body')[0].style = 'display: block';
    document.getElementById('removeAll').addEventListener("click", removeAll);
  </script>
</body>
</html>