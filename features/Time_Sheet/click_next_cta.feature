Feature: Time sheet  

Scenario Outline: To verify the click functionality next CTA

Given Open browser and Start Application "<url>"
Then I enter valid "<username>" and "<password>"
Then I click signin and home page open
Then I see hover effect on next button
When I click on next cta 
Then I see next date on header
Then I see hover effect on prev button
When click prev button
Then I see the previous date on header

Examples: 
<<<<<<< HEAD
| url                           | username        | password |
=======
| url                                      | username        | password |
>>>>>>> be355a8771dec742ec18c6f19a0e132c6bcec820
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 |  
