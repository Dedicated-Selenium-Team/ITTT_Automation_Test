Feature: Click Edit Button

Scenario Outline: Verify click functionality for Edit button

Given Open browser and Start Application (Edit)"<url>"

When Enter valid "<username>" and "<password>"
Then User should be logged in and home page should be open

Then Edit icon for project should be visible in Web Page
Then After I click on the Edit icon pop up should get display
Then After I click on the update entry button, hrs should get display/ reflected on the page "<hrs>"

Examples: 
<<<<<<< HEAD
| url                            | username            | password     | hrs |
=======
| url                                      | username            | password     | hrs |
>>>>>>> be355a8771dec742ec18c6f19a0e132c6bcec820
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com     | admin123     | 3   |