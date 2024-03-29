Synopsis: Secure Message Sharing Application

Objective:
The objective of this project is to develop a secure message sharing application that allows users to send and receive encrypted messages securely over the internet.

Key Features:

1. Encryption and Decryption: Messages are encrypted before storage and decrypted upon retrieval using AES-256-CBC encryption algorithm to ensure secure communication.

2. Expiration: Messages can be set to expire after a specified time, providing additional security and privacy by automatically deleting them from the database.

3. Read Status: Messages can be marked as read, allowing users to track which messages they have already viewed.

Flow of the Application:

1. Home Page:
Upon accessing the application, users are directed to the home page.
The home page provides buttons to navigate to different functionalities:
"Read Message": Allows users to retrieve and view encrypted messages.
 "Send Message": Allows users to share encrypted messages with recipients.
"Set User": Allows users to set up their user profile, including username, email, and decryption key.

2. Set User:
User clicks on the "Set User" button on the home page to access the "Set User" functionality.
User is directed to the "Set User" page where they can input their user details.
User enters the following details:
 Username: Unique identifier for the user.
Email: Email address associated with the user's account.
Decryption Key: Key used for decrypting messages received by the user.
Upon submission, the user details are stored in the database for future reference.

3. Share Message:
User clicks on the "Send Message" button on the home page to access the "Share Message" functionality.
User is directed to the "Share Message" page where they can compose and send a new message.
User enters the message content, recipient's Email (unique id).
 Upon submission, recipient's Email is check in our database for existence.
If recipient's Email is not exist than show error message of user not exists.
 If recipient's Email is exist than the message is encrypted using that recipient's Decryption Key with AES-256-CBC encryption algorithm.
The encrypted message along with other details is stored in the database.

4. Retrieve Message:
Recipient clicks on the "Read Message" button on the home page to access the "Retrieve Message" functionality.
Recipient is directed to the "Retrieve Message" page where they can retrieve and decrypt a message sent to them.
Recipient enters the recipient's Email and decryption key set by the user.
The application retrieves the encrypted message associated with the provided recipient's Email from the database.
The encrypted message is decrypted using the decryption key provided by the recipient.
The decrypted message is displayed to the recipient for viewing.
The message is marked as read in the database to indicate that it has been viewed by the recipient and deleted.

Conclusion:
The secure message sharing application provides a convenient and secure way for users to communicate sensitive information while ensuring confidentiality and privacy. By encrypting messages before storage and providing options for message expiry and read status tracking, the application enhances the security of communication over the internet. Additionally, the ability to set up user profiles adds a layer of personalization and customization to the user experience.
