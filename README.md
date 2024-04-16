benhugh01
password
localhost/digitallibrary.php

Issue 1:
the delete button in the 'Members' Page, 'Penalty' Page, and 'Manage Staff' in the admin panel they don't work 

Solution:
Your Button was using a href, Href cant trigger functions so you delete function was not executed. I changed it to an anchor tag, How ever where it worked, it was working because you made an onclick function call a certain differnt function called confirmDelete which allows you to delete. I recommend you to use everything the same way either use the onclick method and a button tag or use anchor tag and the correct method calling it.

Issue 2:
the profile edit for admin doesn't work, and the admin is not able to update the details and the profile image. And the profile name for admin is hardcoded so it doesn't update itself by whoever is logged in.

Solution:
Mainly done fixes on how the admin verification works and loging in for you correclty. Make sure to do some validation to prevent SQL injection and showing your password is not ideal you need an option to just change password.

In general there some issues where some methods are implemented to handle plain text password which is not ideal to use.

You might have to add more pages to the admin panel if you want to allow admin to delete records but not the staff and migrate the delete buttons and functions to the admin folder and delete the ones from the other folders that are responsible for the delete buttons on the pages created for the staff panel.

Thank you Bence! 
