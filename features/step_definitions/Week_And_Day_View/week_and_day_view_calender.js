'use strict';

var assert=require('assert');

module.exports = function() {
  this.World = require('../../support/world.js').World;

  this.Given(/^Open browser and Start Application "([^"]*)"$/, function (url) {
    this.driver.get(url);
  });

  this.When(/^I enter valid \"([^\"]*)\" and \"([^\"]*)\"$/, function (email,pass) {
    this.driver.findElement({ id: 'email' }).sendKeys(email);
    this.driver.findElement({ id: 'password' }).sendKeys(pass);
  });

  this.Then(/^User should be logged in and home page should be open$/, function () {
    this.driver.findElement({ css: '.submit-btn' }).click();
  });

  this.When(/^Click on the week and day "([^"]*)"$/, function(view){
    this.driver.findElement({ css: view }).click();
    this.driver.sleep(3000);
  });

  this.Then(/^The respective "([^"]*)" should be get displayed$/, function(table){
    this.driver.findElement({ css: table }).then(function(myTable){
      if(myTable.isDisplayed()){
        console.log("Passed => Date wise table is displayed");
      }
      else{
        console.log("Failed => Table is not present");
      }
    });
  });

  this.Then(/^Click on the Calendar icon$/,function(){
    this.driver.findElement({ css:'.date-pick' }).click();
    this.driver.sleep(2000);   
  });

  this.When(/^Click on the any date between Week \(Let say "([^"]*)" "([^"]*)" "([^"]*)"\)$/, function (date,month,year){

    //Select Month from dropdown
    var desiredMonth;
    var selectMonth=this.driver.findElement({css:'.ui-datepicker-month'});
    selectMonth.click();
    selectMonth.findElements({css:'option'}).then(function findMatchingOption(options){
      options.some(function(option){
        option.getText().then(function doesOptionMatch(text){
          if (month === text){
            desiredMonth = option;
            return true;
          }
        });
      });
    })
    .then(function clickOption(){
      if (desiredMonth){
        desiredMonth.click();
      }
    });
    this.driver.sleep(2000);

    //Select Year from dropdown
    var desiredYear;
    var selectYear=this.driver.findElement({css:'.ui-datepicker-year'});
    selectYear.click();
    selectYear.findElements({css:'option'}).then(function findMatchingOption(options){
      options.some(function(option){
        option.getText().then(function doesOptionMatch(text){
          if (year === text){
            desiredYear = option;
            return true;
          }
        });
      });
    })
    .then(function clickOption(){
      if (desiredYear){
        desiredYear.click();
      }
    });
    this.driver.sleep(2000);

    // Select date and click
    this.driver.findElements({ css:'.ui-datepicker-calendar td a'}).then(function(cols){
      for(var i=0;i<cols.length;i++){
        if(i==date){
          cols[i-1].click();
        }
      }
    });
    this.driver.sleep(2000);

    //display selected date from week
    this.driver.findElement({ css:'.input-read-only' }).then(function(date){
      var displayDate=date.getAttribute("value").then(function(selectedDate){
       console.log("Passed => Selected Date with week is "+selectedDate);
     });
    });
  });

};
