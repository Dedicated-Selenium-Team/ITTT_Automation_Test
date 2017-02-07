'use strict';

var assert=require('assert');

module.exports = function() {
  this.World = require('../../support/world.js').World;

  //open url in browser
  this.Given(/^Open browser and Start Application "(.*?)"$/, function(url){
    this.driver.get(url);
  });

  //enter username and password
  this.When(/^I enter valid "(.*?)" and "(.*?)"$/, function(user,pass){
    this.driver.findElement({ id: 'email' }).sendKeys(user);
    this.driver.findElement({ id: 'password' }).sendKeys(pass);
  });

  //click login button
  this.Then(/^User should be logged in and home page should be open$/, function(){
    this.driver.findElement({ css: '.submit-btn' }).click();
  });

  //check user in project
  this.Then(/^User should be in project$/, function(){
    this.driver.findElement({ css: '.hamb' }).click();
    this.driver.findElement({ css: '.all-projects>a' }).click();
    this.driver.sleep(1000);
  });

<<<<<<< HEAD
<<<<<<< HEAD
   //click on hamburger
   this.Then(/^I click on mouse hambergerr$/, function(){
=======
  //click on hamburger
  this.Then(/^I click on mouse hamberger$/, function(){
>>>>>>> 688bf46fd0dcad0a6e060cd60b14802d1abb7b85
=======
  //click on hamburger
  this.Then(/^I click on mouse hamberger$/, function(){
>>>>>>> be355a8771dec742ec18c6f19a0e132c6bcec820
    this.driver.findElement({ css: '.nav-hamber'}).click();
    this.driver.sleep(1000);
  });

<<<<<<< HEAD
<<<<<<< HEAD
   //click on project in project list
   this.Then(/^I click Project in listt$/, function(){
=======
   //click on project in project list
   this.Then(/^I click Project in list$/, function(){
>>>>>>> be355a8771dec742ec18c6f19a0e132c6bcec820
    this.driver.findElement({ css: '.all-projects'}).click();
    this.driver.sleep(1000);
  });

  //click on add project button
  this.When(/^I click on add new project button$/, function(){
    this.driver.findElement({ css: '.addProject' }).click();
    this.driver.sleep(1000);
  });

   //popup should be open
   this.Then(/^I should see a popup$/, function(){
    this.driver.findElement({ css: '.modal-dialog' }).then(function(popup){
      if(popup.isDisplayed()){
        console.log("Popup is Displayed");
      }
    });
    this.driver.sleep(1000);
  });
   
  //enter project detail
  this.Then(/^I enter detail like "(.*?)" and "(.*?)" and "(.*?)"$/, function(pro_name, pro_code, cleint){
    this.driver.findElement({ css: '.form-group #project_name'}).then(function(project){
      var value = project.sendKeys(pro_name);
    });
    this.driver.sleep(500);

    this.driver.findElement({ css: '.form-group #project_code'}).then(function(code){
      var value = code.sendKeys(pro_code);
    });
    this.driver.sleep(500);

    this.driver.findElement({ css: '.form-group #client_name'}).then(function(client){
      var value = client.sendKeys(cleint);
    });
    this.driver.sleep(1000);
  });

   //click on submit
   this.Then(/^I click on submit button$/, function(){
    this.driver.findElement({ css: '.save-project input' }).click();
  });

  //check project is added
  this.Then(/^Project "(.*?)" should be added in project list$/, function(project){
    this.driver.findElements({ css: '.wrap-project .pro_name' }).then(function(project_name){
      for(var i=0; i<project_name.length; i++){
        var name = project_name[i].getText().then(function(pro_name){
          if(project==pro_name){
            console.log("Result ===>> "+pro_name + " is added in project list");
          }
        });
      }      
    });
  });

  // //click on hamburger
  // this.Then(/^I click on mouse hamberger$/, function(){
  //   this.driver.findElement({ css: '.nav-hamber'}).click();
  //   this.driver.sleep(1000);
  // });

  //  //click on project in project list
  //  this.Then(/^I click Project in list$/, function(){
  //   this.driver.findElement({ css: '.all-projects'}).click();
  //   this.driver.sleep(1000);
  // });

  //  //click on add myself to a project
  //  this.When(/^I click on add myself button$/, function(){
  //   this.driver.findElement({ css: '.assign-project'}).click();
  // });

  //  //selecting project name and designaton
  //  this.Then(/^Myself Page should be open and select "(.*?)" and  "(.*?)"$/, function(project, designation){
  //   //select project
  //   var desiredProject;
  //   var selectProject=this.driver.findElement({css:'#project_name'});
  //   selectProject.click();
  //   selectProject.findElements({css:'option'}).then(function findMatchingOption(options){
  //    options.some(function(option){
  //      option.getText().then(function doesOptionMatch(selected_project){
  //        if (project === selected_project){
  //          desiredProject = option;
  //          return true;
  //        }
  //      });
  //    });
  //  })
  //   .then(function clickOption(){
  //    if (desiredProject){
  //      desiredProject.click();
  //    }
  //  });

  //   //select designation
  //   var desiredDesignation;
  //   var selectDesignation=this.driver.findElement({css:'#designation'});
  //   selectDesignation.click();
  //   selectDesignation.findElements({css:'option'}).then(function findMatchingOption(options){
  //    options.some(function(option){
  //      option.getText().then(function doesOptionMatch(selected_des){
  //        if (designation === selected_des){
  //         desiredDesignation = option;
  //         return true;
  //       }
  //     });
  //    });
  //  })
  //   .then(function clickOption(){
  //     if (desiredDesignation){
  //       desiredDesignation.click();
  //     }
  //   });
  //   this.driver.sleep(2000);
  // });

  // //submit the button
  // this.Then(/^I click on submit$/, function(){
  //   this.driver.findElement({ css:'.submit .submit-btn' }).click();
  //   this.driver.sleep(2000);
  // }); 
<<<<<<< HEAD
=======
  //click on project in project list
  this.Then(/^I click Project in list$/, function(){
    this.driver.findElement({ css: '.all-projects'}).click();
    this.driver.sleep(1000);
  });

  //click on add myself to a project
  this.When(/^I click on add myself button$/, function(){
    this.driver.findElement({ css: '.assign-project'}).click();
  });

  //selecting project name and designaton
  this.Then(/^Myself Page should be open and select "(.*?)" and  "(.*?)"$/, function(project, designation){
    //select project
    var desiredProject;
    var selectProject=this.driver.findElement({css:'#project_name'});
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
     }
   });

  //select designation
  var desiredDesignation;
  var selectDesignation=this.driver.findElement({css:'#designation'});
  selectDesignation.click();
  selectDesignation.findElements({css:'option'}).then(function findMatchingOption(options){
   options.some(function(option){
     option.getText().then(function doesOptionMatch(selected_des){
       if (designation === selected_des){
        desiredDesignation = option;
        return true;
      }
    });
   });
 })
  .then(function clickOption(){
    if (desiredDesignation){
      desiredDesignation.click();
    }
  });
  this.driver.sleep(2000);
});

  //submit the button
  this.Then(/^I click on submit$/, function(){
    this.driver.findElement({ css:'.submit .submit-btn' }).click();
    this.driver.sleep(2000);
  }); 

  // //click on add project button
  // this.When(/^I click on add new project button$/, function(){
  //   this.driver.findElement({ css: '.addProject' }).click();
  //   this.driver.sleep(1000);
  // });

  //  //popup should be open
  //  this.Then(/^I should see a popup$/, function(){
  //   this.driver.findElement({ css: '.modal-dialog' }).then(function(popup){
  //     if(popup.isDisplayed()){
  //       console.log("Popup is Displayed");
  //     }
  //   });
  //   this.driver.sleep(1000);
  // });
  
  //  //enter project detail
  //  this.Then(/^I enter detail like "(.*?)" and "(.*?)" and "(.*?)"$/, function(pro_name, pro_code, cleint){
  //   this.driver.findElement({ css: '.form-group #project_name'}).then(function(project){
  //     var value = project.sendKeys(pro_name);
  //   });
  //   this.driver.sleep(500);

  //   this.driver.findElement({ css: '.form-group #project_code'}).then(function(code){
  //     var value = code.sendKeys(pro_code);
  //   });
  //   this.driver.sleep(500);

  //   this.driver.findElement({ css: '.form-group #client_name'}).then(function(client){
  //     var value = client.sendKeys(cleint);
  //   });
  //   this.driver.sleep(1000);
  // });

  // //click on submit
  // this.Then(/^I click on submit button$/, function(){
  //   this.driver.findElement({ css: '.save-project input' }).click();
  // });

  // //check project is added
  // this.Then(/^Project "(.*?)" should be added in project list$/, function(project){
  //   this.driver.findElements({ css: '.wrap-project .pro_name' }).then(function(project_name){
  //     for(var i=0; i<project_name.length; i++){
  //       var name = project_name[i].getText().then(function(pro_name){
  //         if(project==pro_name){
  //           console.log("Result ===>> "+pro_name + " is added in project list");
  //         }
  //       });
  //     }      
  //   });
  // });
>>>>>>> 688bf46fd0dcad0a6e060cd60b14802d1abb7b85
=======
>>>>>>> be355a8771dec742ec18c6f19a0e132c6bcec820
};