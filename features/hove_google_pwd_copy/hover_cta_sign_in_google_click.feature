Feature: Sign in 

Scenario Outline: Verify hover and cta for sign in with google and popup

Given Open browser and Start Application "<url>"
When I enter valid "<username>" and "<password>"
Then Verify the CTA is "<cta>"
Then Verify Hover on sign in with google
Then Click on sign in with google button and check popup is displayed

Examples: 
<<<<<<< HEAD
| url                           | username        | password | cta |
=======
| url                                      | username        | password | cta |
>>>>>>> be355a8771dec742ec18c6f19a0e132c6bcec820
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | Sign In With Google |

