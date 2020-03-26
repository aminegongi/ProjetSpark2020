var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :
  if (currentTab >= x.length) {
    //...the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false:
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}

$("document").ready(function() {
  $(".slider").rangeslider();
});
$.fn.rangeslider = function(options) {
  this.each(function(i, elem){
      var obj = $(elem); // input element
      var defautValue = obj.attr("value");

      var slider_max  = (obj.attr("max"));
      var slider_min  = (obj.attr("min"));
      var slider_step = (obj.attr("step"));
      var slider_stop = (slider_max - slider_min) / slider_step;
      var step_percentage = 100 / slider_stop;

      console.log(step_percentage); 

      var color = "";
      var classlist = obj.attr("class").split(/\s+/);
      $.each(classlist, function(index, item) {
          if(item.startsWith('slider-')) {
              color = item;
          }
      });

      if(color == "") {
          color = "slider-blue";
      }

      if(slider_stop <= 30){
          var i;
          var dots = "";
          for (i = 1; i < slider_stop; i++){
              dots += "<div class='dot' id='"+ i +"' style='left:"+ step_percentage * i +"%;'></div>";
          }
      }
      else{
          var dots = "";
      }

      obj.wrap("<span class='slider " + color + "'></span>");
      obj.after("<span class='slider-container " + color + "'><span class='bar'><span></span>" + dots + "</span><span class='bar-btn'><span>0</span></span></span>");
      obj.attr("oninput", "updateSlider(this)");
      updateSlider(this);
      return obj;
  });
};


function updateSlider(passObj) {
  var obj = $(passObj);
  var value = obj.val();
  var min = obj.attr("min");
  var max = obj.attr("max");
  var range = Math.round(max - min);
  var percentage = Math.round((value - min) * 100 / range);
  var nextObj = obj.next();

  var btn = nextObj.find("span.bar-btn");
  
  if(value == min){
      nextObj.find("span.bar-btn").css("left", percentage + "%");
  }
  else if(value == max){
      nextObj.find("span.bar-btn").css("left", "calc(" + percentage + "% - " + btn.width() + "px");
  }
  else{
      nextObj.find("span.bar-btn").css("left", "calc(" + percentage + "% - " + btn.width()/2 + "px");
  }
  nextObj.find("span.bar > span").css("width", percentage + "%");
  nextObj.find("span.bar-btn > span").text(value);
};