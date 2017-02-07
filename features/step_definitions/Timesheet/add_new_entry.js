'use strict';

var assert=require('assert');

module.exports = function() {
  this.World = require('../../support/world.js').World;

  //open url in browser
  this.Given(/^Open browser and Start Application \(New\)"([^"]*)"$/, function(url){
   this.driver.get(url);
 });

   //enter username and password
   this.When(/^I enter the valid "([^"]*)" and "([^"]*)"$/, function(user,pass){
    this.driver.findElement({ id: 'email' }).sendKeys(user);
    this.driver.findElement({ id: 'password' }).sendKeys(pass);
  });

   //click login button
   this.Then(/^User should be logged in and home\-page should be open$/, function(){
    this.driver.findElement({ css: '.submit-btn' }).click();
  });

   //click new entry button
   this.When(/^I click on New Entry button$/, function(){
    this.driver.findElement({ css: '#daily-add' }).click();
  });

   //popup should be display
   this.Then(/^New Entry popup should be display$/, function(){
    this.driver.findElement({ css: '.day-timesheet .modal-dialog' }).then(function(popup){
      if(popup.isDisplayed()){
        console.log("New Entry Popup is displayed");
        console.log(" ");
      }
    });
  });

   //click on save button for validation
   this.When(/^I Click on save button without value$/, function(){
    this.driver.sleep(1000);

    this.driver.findElement({ id:'save' }).then(function(save){
     save.click();
   });
    this.driver.sleep(1000);
  });

  //check error message
  this.Then(/^SHould be get error message$/, function(){
    this.driver.findElements({ css:'.error' }).then(function(error_list){
      console.log("Error when you click without filling the field:");
      for(var i=0;i<error_list.length;i++){
       var values=error_list[i].getText().then(function(error_text){
        if(error_text){
          console.log("Error message: "+error_text);
        }
      });
     }
   });
  }); 

  //enter the text in field
  this.Then(/^If I not fill the "(.*?)", "(.*?)", "(.*?)" and "(.*?)"$/, function(project, designation, task, hour){
    //enter project name
    this.driver.sleep(1000);
    var desiredProject;
    var selectProject=this.driver.findElement({ id:'project' });
    selectProject.click();
    selectProject.findElements({css:'option'}).then(function findMatchingOption(options){
      options.some(function(option){
        option.getText().then(function doesOptionMatch(selected_project){
          if (project === selected_project){
            desiredProject = option;
            return true;
          }
        });
      });
    })
    .then(function clickOption(){
      if (desiredProject){
        desiredProject.click();
      }else{
        console.log('');
        console.log( 'Select Project functionality not working or '+ project +' option is not persent');
      }
    });
    
    //enter designation
    this.driver.sleep(1000);
    var desiredDesignation;
    var selectDesignation=this.driver.findElement({ id:'project_desig' });
    selectDesignation.click();
    selectDesignation.findElements({css:'option'}).then(function findMatchingOption(options){
      options.some(function(option){
        option.getText().then(function doesOptionMatch(selected_designation){
          if (designation === selected_designation){
            desiredDesignation = option;
            return true;
          }
        });
      });
    })
    .then(function clickOption(){
      if (desiredDesignation){
        desiredDesignation.click();
      }else{
        console.log('');
        console.log( 'Select designation functionality not working or '+ designation+ ' option is not persent or already assigned');
      }
    });

    this.driver.sleep(1000);
    //enter description
    this.driver.findElement({ css: '#comments' }).sendKeys(task);
    
    //enter hours
    this.driver.findElement({ css: '#hrs_locked' }).sendKeys(hour);
  }); 

  //click on save button
  this.Then(/^I click on save button$/, function(){
    this.driver.sleep(1000);

    this.driver.findElement({ id:'save' }).then(function(save){
      save.click();
    });
  });

  //display all project name and designation which assigned or entered
  this.Then(/^New entry "(.*?)" and "(.*?)" should be entered$/, function(project, designation){
    this.driver.sleep(2000);
    this.driver.findElements({ css:'.day-table h3 span' }).then(function(proj_name){
      console.log("");
      for(var i=0;i<proj_name.length;i++){
        var display_project=proj_name[i].getText().then(function(project_val){
          console.log("All Entered project name or designation is  "+project_val);
        });
      }
    });
  });
};