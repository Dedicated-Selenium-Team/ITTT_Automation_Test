Feature: Breadcrums

Scenario Outline: To verify the functionality of breadcrums links
Given Open browser and Start Application "<url>"
When I enter valid "<username>" and "<password>"
Then User should be logged in and home page should be open
Then Click on the Add To MySelf A Project  CTA
Then Detail Page get display and Breadcrumb also get display
Then Now clik on the Breadcrumb link Projects

Examples: 
<<<<<<< HEAD
| url                            | username                       | password  |
=======
| url                                      | username                       | password  |
>>>>>>> be355a8771dec742ec18c6f19a0e132c6bcec820
| http://timetrackingwip.prdxnstaging.com/ | sushant.lawate.prdxn@gmail.com | prdxn2016 |
