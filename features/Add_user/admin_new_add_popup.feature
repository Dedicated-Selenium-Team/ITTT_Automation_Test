Feature: Admin Pop up

Scenario Outline: Verify click On Add New Button and Save Entry 

Given Open browser and Start Application "<url>"
When I enter valid Admin "<username>" and "<password>"
Then User should be logged in and home page should be open
Then I click on mouse hamberger
Then I click User in list
When I click on add new button
Then I should see a popup

When I click save entry button with empty field
Then I should see errore message

When I click on cross symbol top right 
Then popup should be close

When I click on ad new button
When I enter the "<name>", "<contact>", "<username>", "<password>", "<month>", "<year>", "<date>"
Then I should see error message

# When I enter valid entry and click update
# Then I should not see any error message
# Then Field are updated 

Examples: 
<<<<<<< HEAD
| url                           | username        | password | name | contact |  month | year | date |
=======
| url                                      | username        | password | name | contact |  month | year | date |
>>>>>>> be355a8771dec742ec18c6f19a0e132c6bcec820
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | test | 0987654321 | Dec | 2016 | 13 |