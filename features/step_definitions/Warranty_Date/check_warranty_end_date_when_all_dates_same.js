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

  this.Then(/^Place mouse on warranty End date field$/, function () {
    this.driver.actions().mouseMove(this.driver.findElement({ id:'Warrenty-period-end' })).perform();
    this.driver.sleep(2000);
  });

  this.Then(/^Cursor should change to disable symbol$/, function () {
    this.driver.findElement({ id:'Warrenty-period-end' }).then(function(warranty){
      var checkDisabled=warranty.getAttribute('disabled').then(function(isDisabled){
        if(isDisabled=="true"){
          console.log("Warranty End Date is disabled");
        }
        else{
         console.log("Warranty End Date is not disabled"); 
       }
     });
    });
  });

  this.Then(/^Field of Warranty end date should display the dd\/mm\/yyyy$/, function () {
    this.driver.findElement({ id:'Warrenty-period-end' }).then(function(warranty){
      var warrDAte=warranty.getAttribute('value').then(function(currValue){
        console.log("current warranty end date is "+currValue);
      });
    });
  });
  

  this.Then(/^Select date from project start date from calender \(Let say "([^"]*)" "([^"]*)" "([^"]*)"\)$/, function (date,month,year) {

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

    this.driver.findElement({ id:'project-start-date' }).then(function(projDate){
      var currprojDate=projDate.getAttribute('value').then(function(currProjDate){
        console.log("Current Project Start Date is "+currProjDate);
      });
    });

    this.driver.sleep(2000);
  });

  this.Then(/^Set the same date for Phase I End Date from calender \(Let say "([^"]*)" "([^"]*)" "([^"]*)"\)$/, function (date,month,year) {

    this.driver.findElement({ id:'phase-I-end-date' }).click();
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
    this.driver.findElements({ css:'.ui-datepicker-calendar td'}).then(function(cols){
      for(var i=0;i<cols.length;i++){
        if(i==date){
          cols[i+3].click();
        }
      }
    });

    this.driver.findElement({ id:'phase-I-end-date' }).then(function(phaseIDate){
      var currphaseIDate=phaseIDate.getAttribute('value').then(function(currPhaseIDate){
        console.log("Current Phase I End Date is "+currPhaseIDate);
      });
    });

    this.driver.sleep(2000);
  });

  this.Then(/^Set the same date for Phase II End Date from calender \(Let say "([^"]*)" "([^"]*)" "([^"]*)"\)$/, function (date,month,year) {
    this.driver.findElement({ id:'phase-II-end-date' }).click();
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
    this.driver.findElements({ css:'.ui-datepicker-calendar td'}).then(function(cols){
      for(var i=0;i<cols.length;i++){
        if(i==date){
          cols[i+3].click();
        }
      }
    });

    this.driver.findElement({ id:'phase-II-end-date' }).then(function(phaseIIDate){
      var currphaseIIDate=phaseIIDate.getAttribute('value').then(function(currPhaseIIDate){
        console.log("Current Phase II End Date is "+currPhaseIIDate);
      });
    });

    this.driver.sleep(2000);
  });

  this.Then(/^Warranty end daye should be same as the date set in all the filed$/, function () {

    //clear warranty days and holidays 
    this.driver.findElement({ id:'Warrenty-days' }).clear();
    this.driver.findElement({ id:'Warrenty-period-holiday' }).clear();

    this.driver.findElement({ id:'Warrenty-period-end' }).then(function(warrDate){
      var currWarrDate=warrDate.getAttribute('value').then(function(currDate){
        console.log("Warranty Date is "+currDate);
      });
    });
  });
};

