Feature: Users Tab

Scenario Outline: Verify the click functionality of "Add new" CTA when admined is logged in

Given Open browser and Start the Application "<url>"
When Enter valid "<username>" and "<password>"
Then User should be logged-in and home page should be open
Then User should be in users tab
Then Click on Add new button present on the left top corner, pop-up will get displayed
Then Fill all the fields with invalid data

Examples: 
<<<<<<< HEAD
| url                            | username        | password |
=======
| url                                      | username        | password |
>>>>>>> be355a8771dec742ec18c6f19a0e132c6bcec820
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 |
