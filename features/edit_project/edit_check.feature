Feature: Click On edit link
As an internet user
I want to be able to click on edit icon

Scenario Outline: Verify click functionality for edit link
Given I open site in browser"<url>"
When I have to enter "<username>" and "<password>"
Then I click button for login 
Then I click on mouse hamberger
When I click Project in list
Then I check hover and tooltip on edit option
When I click on edit icon
Then I should be see client name and project name
And I should see update button

Examples:
<<<<<<< HEAD
| url                           | username        | password | 
=======
| url                                      | username        | password | 
>>>>>>> be355a8771dec742ec18c6f19a0e132c6bcec820
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | 
