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

  this.Then(/^User should be in project$/,function(){
    this.driver.findElement({ css: '.hamb' }).click();
    this.driver.findElement({ css: '.all-projects>a' }).click();
    this.driver.sleep(2000);
  });

  this.Then(/^I click on any link of Estimation project \(Let us check this project "([^"]*)"\)$/, function (projNumber) {

    this.driver.findElement({ css:'#tabs-1 .wrap-project:nth-of-type('+projNumber+') .estimate-span .detail-plan' }).click();
    this.driver.sleep(2000);
  });

  this.Then(/^Keep the date as default \(Present date\)$/, function () {
    this.driver.findElement({ id:'project-start-date' }).click();
    this.driver.sleep(2000);

    this.driver.findElement({ css:'.ui-datepicker-calendar td a.ui-state-active' }).click();

    this.driver.findElement({ id:'project-start-date' }).then(function(projStart){
      var selectedDate=projStart.getAttribute('value').then(function(value){
        console.log("Project Start date is "+value);
      });
    });
  });

  this.Then(/^Field of Timeline Till Go\-Live \(days\) should display zero$/, function () {
    this.driver.findElement({ id:'p1-go-live' }).then(function(goLive){
      var checkVal=goLive.getAttribute('value').then(function(value){
        if(value==""){
          console.log("Field of timeline till go live days are 0");
        }
        else{
          console.log("Field of timeline till go live days are "+value);
        }
      });
    });
  });

  this.Then(/^Change the date from calender \(Let say "([^"]*)" "([^"]*)" "([^"]*)"\)$/, function (date,month,year) {
    this.driver.findElement({ id:'project-start-date' }).click();
    this.driver.sleep(2000);

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

    // Select date and click
    this.driver.findElements({ css:'.ui-datepicker-calendar td a'}).then(function(cols){
      for(var i=0;i<cols.length;i++){
        if(i==date){
          cols[i-1].click();
        }
      }
    });

    this.driver.findElement({ id:'project-start-date' }).then(function(projStart){
      var selectedDate=projStart.getAttribute('value').then(function(value){
        console.log("Project Start date is "+value);
      });
    });
  });

  this.Then(/^Field of Timeline Till Go\-Live \(days\) should again display zero$/, function () {
    this.driver.findElement({ id:'p1-go-live' }).then(function(goLive){
      var checkVal=goLive.getAttribute('value').then(function(value){
        if(value==""){
          console.log("Field of timeline till go live days are 0");
        }
        else{
          console.log("Field of timeline till go live days are "+value);
        }
      });
    });
  });
};

