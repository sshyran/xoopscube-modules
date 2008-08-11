<?php
/**
 * @version $Id: main.php 434 2008-04-22 01:13:57Z hodaka $
 * @author kuri <kuri@keynext.co.jp>
 */

// <--- LANG PROPERTY --->
define ( '_MD_D3BLOG_LANG_RDF_NAVIGATION','RDF Navigation' );
define ( '_MD_D3BLOG_LANG_WHOS_ENTRY','%s\'s ' );
define ( '_MD_D3BLOG_LANG_WHAT_CATEGORY_ENTRY','Category  %s ' );
define ( '_MD_D3BLOG_LANG_LATEST_ENTRY_FEED','Latest entries feeder' );
define ( '_MD_D3BLOG_LANG_RDF_GUIDE','%s Feeder' );
define ( '_MD_D3BLOG_LANG_POST_ENTRY','Post entry' );
define ( '_MD_D3BLOG_LANG_POST_PREVIEW','Preview' );
define ( '_MD_D3BLOG_LANG_CONFIRM_DELETE','Confirm to delete' );
define ( '_MD_D3BLOG_LANG_CATEGORY_NAME','Category name' );
define ( '_MD_D3BLOG_LANG_MAIN','Category top');
define ( '_MD_D3BLOG_LANG_BLOG_TITLE','Title' );
define ( '_MD_D3BLOG_LANG_BLOG_CONTENTS','Contents' );
define ( '_MD_D3BLOG_LANG_CREATE_DATE','Created on' );
define ( '_MD_D3BLOG_LANG_PUBLISH_DATE','Publish date' );
define ( '_MD_D3BLOG_LANG_APPROVAL','Approval' );
define ( '_MD_D3BLOG_LANG_APPROVED','Approved' );
define ( '_MD_D3BLOG_LANG_UNAPPROVED','Pending' );
define ( '_MD_D3BLOG_LANG_APPROVE_ENTRY','Approve this entry' );
define ( '_MD_D3BLOG_LANG_SET_PUBLISHABLE','Change publish date' );
define ( '_MD_D3BLOG_LANG_SELECT_GROUPS','Permitted groups' );
define ( '_MD_D3BLOG_LANG_BLOGGER_NAME','Author' );
define ( '_MD_D3BLOG_LANG_ENTRY_OPTIONS','Options' );
define ( '_MD_D3BLOG_LANG_HTML_ENABLE','HTML allowed' );
define ( '_MD_D3BLOG_LANG_AUTO_BR','Auto break' );
define ( '_MD_D3BLOG_LANG_XCODE_ENABLE','XCODE allowed' );
define ( '_MD_D3BLOG_LANG_CATEGORY','Category' );
define ( '_MD_D3BLOG_LANG_UPDATE_PING','Send an update ping' );
define ( '_MD_D3BLOG_LANG_SELECT_PING_URLS','Choose updateping urls(max. %d)' );
define ( '_MD_D3BLOG_LANG_AUTODISCOVER','Autodiscover' );
define ( '_MD_D3BLOG_LANG_TRACKBACKS_OUTBOUND','Trackbacks outbound' );
define ( '_MD_D3BLOG_LANG_TRACKBACKS_INBOUND','Trackbacks inbound' );
define ( '_MD_D3BLOG_LANG_TRACKBACK_URL','Trackback url' );
define ( '_MD_D3BLOG_LANG_TRACKBACK_URL_DESC','Each must be seperated by break' );
define ( '_MD_D3BLOG_LANG_DELETE_TRACKBACK_SENT','Delete traclbacks outbound' );
define ( '_MD_D3BLOG_LANG_DELETE_TRACKBACKS_RECEIVED','Delete traclbacks inbound' );
define ( '_MD_D3BLOG_LANG_LINK_TO_PAGE_OF','LINK TO PAGE OF %s' );
define ( '_MD_D3BLOG_LANG_ENTRY_INFORMATION','Entry Information' );
define ( '_MD_D3BLOG_LANG_READ_BLOGGER_ENTRIES','Read %s\'s' );
define ( '_MD_D3BLOG_LANG_EDIT_THIS_ENTRY','Edit this entry' );
define ( '_MD_D3BLOG_LANG_READ_COMMENTS','Read comments of %s' );
define ( '_MD_D3BLOG_LANG_READ_TRACKBACKS','Read trackbacks of %s' );
define ( '_MD_D3BLOG_LANG_HOW_MANY_READ','Hits' );
define ( '_MD_D3BLOG_LANG_COMMENTS','Comments' );
define ( '_MD_D3BLOG_LANG_TRACKBACK','Trackback' );
define ( '_MD_D3BLOG_LANG_READS','Hits' );
define ( '_MD_D3BLOG_LANG_ENTRY_HEADER_NAVIGATION','Header Navigation' );
define ( '_MD_D3BLOG_LANG_ENTRY_FOOTER_NAVIGATION','Footer Navigation' );
define ( '_MD_D3BLOG_LANG_SEE_BLOGGER_PROFILE','See %s\'s profile' );
define ( '_MD_D3BLOG_LANG_TRACKBACK_SENT','Trackback sent to' );
define ( '_MD_D3BLOG_LANG_READ_MORE','...more' );
define ( '_MD_D3BLOG_LANG_CANT_READ_FARTHER','...Can\'t read farther' );
define ( '_MD_D3BLOG_LANG_READ_WHOLE_OF','Read whole of %s' );
define ( '_MD_D3BLOG_LANG_NOTIFY_WHEN_APPROVED','Notify when this entry approved' );
define ( '_MD_D3BLOG_LANG_AUTO_DISCOVERY','Autodiscover' );
define ( '_MD_D3BLOG_LANG_ENTRIES_IN_PERIOD','Period %s' );
define ( '_MD_D3BLOG_LANG_ENTRIES_OF','%s\'s entries' );
define ( '_MD_D3BLOG_LANG_ENTRIES_OF_CATEGORY','Entries of category %s' );
define ( '_MD_D3BLOG_LANG_PAGE_HEADER_NAVIGATION','PAGE HEADER NAVIGATION' );
define ( '_MD_D3BLOG_LANG_PAGE_FOOTER_NAVIGATION','PAGE FOOTER NAVIGATION' );
define ( '_MD_D3BLOG_LANG_CURRENT_CATEGORY_NAVI_MAP','NAVI MAP TO THE CURRENT CATEGORY' );
define ( '_MD_D3BLOG_LANG_D3BLOG_MAIN','Main' );
define ( '_MD_D3BLOG_LANG_READ_CATEGORY_OF','Read %s Category' );
define ( '_MD_D3BLOG_LANG_BACK_AND_FORTH_NAVI_MAP','NAVI MAP TO BACK AND FORTH' );
define ( '_MD_D3BLOG_LANG_GO_BACK_TO_PREV_ENTRY','GO BACK TO THE PREVIOUS ENTRY %s' );
define ( '_MD_D3BLOG_LANG_GO_TO_NEXT_ENTRY','GO TO THE NEXT ENTRY %s' );
define ( '_MD_D3BLOG_LANG_NEXT','Next' );
define ( '_MD_D3BLOG_LANG_PREVIOUS','Previous' );
define ( '_MD_D3BLOG_LANG_GET_VALID_TRACKBACK_URL_KEY','Get valid trackback url' );
define ( '_MD_D3BLOG_LANG_TRACKBACK_URL_IS','Trackback url is %s.' );
define ( '_MD_D3BLOG_LANG_TRACKBACK_SENT_TO','Sent to' );
define ( '_MD_D3BLOG_LANG_TRACKBACK_RECEIVED_FROM','Received from' );
define ( '_MD_D3BLOG_LANG_LINK_TO_TRACKBACK_RECEIVER','LINK TO TRACKBACK RECEIVER' );
define ( '_MD_D3BLOG_LANG_LINK_TO_TRACKBACK_TRANSMITTER','LINK TO TRACKBACK SENDER' );
define ( '_MD_D3BLOG_LANG_COMMENTS_NOTICE','Comments' );
define ( '_MD_D3BLOG_LANG_LATEST_ENTRIES','Latest entries' );
define ( '_MD_D3BLOG_LANG_HEADER_NAVIGATION','HEADER NAVIGATION' );
define ( '_MD_D3BLOG_LANG_CATEGORY_NAVIGATION_PATH','CATEGORY NAVIGATION PATH' );
define ( '_MD_D3BLOG_LANG_INTO_CURRENT_CATEGORY_NAVIGATION','CATEGORY NAVIGATION TO THE CURRENT' );
define ( '_MD_D3BLOG_LANG_READ_ENTRY_OF_CATEGORY','Read entries of category %s' );
define ( '_MD_D3BLOG_LANG_BACK_AND_FORTH_NAVIGATION','BACK AND FORTH NAVIGATION' );
define ( '_MD_D3BLOG_LANG_INSERT_SEPERATOR','Seperator' );
define ( '_MD_D3BLOG_LANG_INSERT_SEPERATOR_ON_CLICK',
        'The seperator splits the contents, the first half as an excerpt, the latter as a body. '.
        'Below is the case of groups with no entry-by privilege:<br />'.
        'A title and an excerpt are visible to the groups forbidden when the preferences is on. '.
        'If a seperator is located at the beginning of the contents, then will show a title only. '.
        'Whole the entry is invisible if a seperator does not exist.' );
define ( '_MD_D3BLOG_LANG_INSERT_HELP','Help' );
define ( '_MD_D3BLOG_LANG_DISPLAY_XCODE_PALLET','Display xcode editor.' );
define ( '_MD_D3BLOG_LANG_DISPLAY_OPTIONS','Display options' );
define ( '_MD_D3BLOG_LANG_SELECT_ALL','Select all' );
define ( '_MD_D3BLOG_LANG_RETRIEVE_ARCHIVES','Retrieve archives' );
define ( '_MD_D3BLOG_LANG_EXTRACT_ARCHIVES','Extract archives' );
define ( '_MD_D3BLOG_LANG_ARCHIVE_LIST','Archive list' );
define ( '_MD_D3BLOG_LANG_ARCHIVE_SUMMARY','This is an archives list' );
define ( '_MD_D3BLOG_LANG_ARCHIVE_COUNTER','%d Arch.' );
define ( '_MD_D3BLOG_LANG_NO_ARCHIVE','No archives' );
define ( '_MD_D3BLOG_LANG_ARCHIVE_FOOTER_NAVIGATION','ARCHIVES FOOTER NAVIGATION' );
define ( '_MD_D3BLOG_LANG_POST_COMMENT','Post a comment' );
define ( '_MD_D3BLOG_LANG_EDIT_COMMENT','Edit a comment' );
define ( '_MD_D3BLOG_LANG_REPLY_TO_COMMENT','Reply' );
define ( '_MD_D3BLOG_LANG_DELETE_COMMENT','Delete a comment' );
define ( '_MD_D3BLOG_LANG_PREVIEW_COMMENT','Preview' );
define ( '_MD_D3BLOG_LANG_APPROVAL_MANAGER','Approval manager' );
define ( '_MD_D3BLOG_LANG_BLOG_NAME','Blog name' );
define ( '_MD_D3BLOG_LANG_BLOG_EXCERPT','Excerpt' );
define ( '_MD_D3BLOG_LANG_BLOG_EXCERPT_INBOUND','Excerpt inbound' );
define ( '_MD_D3BLOG_LANG_BLOG_NAME_INBOUND','Blog name inboundE' );
define ( '_MD_D3BLOG_LANG_TRACKBACK_DATE_INBOUND','Date received' );
define ( '_MD_D3BLOG_LANG_BLOG_ID','Blog id' );
define ( '_MD_D3BLOG_LANG_COM_REFERENCE', 'Comment from' );
define ( '_MD_D3BLOG_LANG_COM_PREVIEW', 'Preview a comment' );
define ( '_MD_D3BLOG_LANG_COM_PENDING', 'Pending' );
define ( '_MD_D3BLOG_LANG_COM_ACTIVE', 'Active' );
define ( '_MD_D3BLOG_LANG_COM_HIDDEN', 'Hidden' );
define ( '_MD_D3BLOG_LANG_COM_CONFIRM_DELETE', 'Confirm to delete a comment' );
define ( '_MD_D3BLOG_LANG_COM_ARE_YOU_SURE_TO_DELETE', 'Are you sure to delete this comment?' );
define ( '_MD_D3BLOG_LANG_COM_DELETE_THIS', 'Delete this comment' );
define ( '_MD_D3BLOG_LANG_COM_DELETE_THREADS', 'Delete replies too' );
define ( '_MD_D3BLOG_LANG_COM_POST', 'Post a comment' );
define ( '_MD_D3BLOG_LANG_COM_WELCOME', '%s, Lleave a comment.' );
define ( '_MD_D3BLOG_LANG_COM_REVICE', 'Editing %s\'s commentT.' );
define ( '_MD_D3BLOG_LANG_COM_LOGIN', 'Comment after' );
define ( '_MD_D3BLOG_LANG_COM_ANONYMOUS', 'Anonymous are welcomed' );
define ( '_MD_D3BLOG_LANG_COM_REMEMBERME', 'Remember me' );
define ( '_MD_D3BLOG_LANG_COM_NAME', 'Name' );
define ( '_MD_D3BLOG_LANG_COM_NAME_REMARK', '(must fill)' );
define ( '_MD_D3BLOG_LANG_COM_EMAIL', 'e-mail' );
define ( '_MD_D3BLOG_LANG_COM_EMAIL_REMARK', '(must fill. Won\'t be public.)' );
define ( '_MD_D3BLOG_LANG_COM_URL', 'Url' );
define ( '_MD_D3BLOG_LANG_COM_MESSAGE', 'Comment' );
define ( '_MD_D3BLOG_LANG_COM_STATUS', 'Status' );
define ( '_MD_D3BLOG_LANG_COM_DISPLAY_OPTIONS', 'Display options' );
define ( '_MD_D3BLOG_LANG_COM_DOHTML', 'Html is allowed' );
define ( '_MD_D3BLOG_LANG_COM_DOAUTOWRAP', 'Auto wrap' );

// <--- MESSAGE PROPERTY --->
define ( '_MD_D3BLOG_MESSAGE_DB_UPDATE_SUCCESS','Updaing %s was successfully finished.' );
define ( '_MD_D3BLOG_MESSAGE_DB_DELETE_SUCCESS','Deleting %s was successfully finished.' );
define ( '_MD_D3BLOG_MESSAGE_DB_UPDATE_FAILED','Updaing %s failed.' );
define ( '_MD_D3BLOG_MESSAGE_DB_DELETE_FAILED','Deleting %s failed.' );
define ( '_MD_D3BLOG_MESSAGE_ARE_YOU_SURE_TO_DELETE','Are you sure to delete?' );
define ( '_MD_D3BLOG_MESSAGE_TICKET_LIFETIME','Ticket will be expired in %s minutes.' );
define ( '_MD_D3BLOG_MESSAGE_ENTRY_POSTED_SUCCESSFULLY','Entry was successfully submitted.' );
define ( '_MD_D3BLOG_MESSAGE_ENTRY_POST_FAULT','Submitting an entry failed.' );
define ( '_MD_D3BLOG_MESSAGE_WAIT_UNTIL_ENTRY_APPROVED_BY_ADMIN','Wait until an entry will be approved by admin.' );
define ( '_MD_D3BLOG_MESSAGE_STARTING_TRACKBACK','Starting to send trackback.' );
define ( '_MD_D3BLOG_MESSAGE_AUTODISCOVERY_FAILED','Failed to autodiscover %s\'s ping url. Re-input ping url.' );
define ( '_MD_D3BLOG_MESSAGE_TRACKBACK_FINISHED_SUCCESSFULLY','Trackback submittance was finished.' );
define ( '_MD_D3BLOG_MESSAGE_STARTING_UPDATEPING','Starting to send update ping.' );
define ( '_MD_D3BLOG_MESSAGE_UPDATEPING_FINISHED_SUCCESSFULLY','Update ping was finished.' );
define ( '_MD_D3BLOG_MESSAGE_NOW_FINISHING','Now finishing all.' );
define ( '_MD_D3BLOG_MESSAGE_DB_TRACKBACK_FAILED','An error occurred while updating trackback database.' );
define ( '_MD_D3BLOG_MESSAGE_TRACKBACK_SUCCESS','Successfully sent trackckback to %s.' );
define ( '_MD_D3BLOG_MESSAGE_TRACKBACK_FAILED','Trackback to %s failed.' );
define ( '_MD_D3BLOG_MESSAGE_UPDATEPING_SUCCESS','Updateping to %s was successed.' );
define ( '_MD_D3BLOG_MESSAGE_UPDATEPING_FAILED','Updateping to %s failed.' );
define ( '_MD_D3BLOG_MESSAGE_FAILED_AUTO_DISCOVERY','Failed to autodiscover trackback url of %s.' );
define ( '_MD_D3BLOG_MESSAGE_SORRY_WAIT_UNTILL_PUBLISHED','Your entry is pending until an admin approves.' );
define ( '_MD_D3BLOG_MESSAGE_YOU_CHOICED','No entry was found in %s.' );
define ( '_MD_D3BLOG_MESSAGE_COM_WELCOMED','Thanks to your comment.' );
define ( '_MD_D3BLOG_MESSAGE_COM_WAIT_UNTIL_APPROVED','Wait until we confirm your message.' );
define ( '_MD_D3BLOG_MESSAGE_COM_DELETE_SUCCESS', 'Deleted comment.' );

// <--- ERROR PROPERTY --->
define ( '_MD_D3BLOG_ERROR_TITLE_REQUIRED','A title is required.' );
define ( '_MD_D3BLOG_ERROR_TITLE_SIZEOVER','A title is sizeover.' );
define ( '_MD_D3BLOG_ERROR_URL_MAXOVER','Updating urls are more than max.' );
define ( '_MD_D3BLOG_ERROR_NO_PERM_FOR_POST','You have no permission for post.' );
define ( '_MD_D3BLOG_ERROR_NO_PERM_FOR_EDIT_OTHERS','You have no permission for editing others\'s.' );
define ( '_MD_D3BLOG_ERROR_NO_PERM_FOR_VIEW','You have no permission to view this blog.' );
define ( '_MD_D3BLOG_ERROR_NO_SUCH_ENTRY','No such an entry found.' );
define ( '_MD_D3BLOG_ERROR_DB_UPDATE_FAILURE','Updating %s failed. Call an admin.' );
define ( '_MD_D3BLOG_ERROR_DB_DELETE_FAILURE','Deleting %s failed. Call an admin.' );
define ( '_MD_D3BLOG_ERROR_CATEGORY_REQUIRED','A category is required.' );
define ( '_MD_D3BLOG_ERROR_CONTENTS_REQUIRED','Contents are required.' );
define ( '_MD_D3BLOG_ERROR_DATE_FORMAT_ILLEGAL','Date format %s is illegal.' );
define ( '_MD_D3BLOG_ERROR_NO_SUCH_USER','No such a user %s was found.' );
define ( '_MD_D3BLOG_ERROR_NO_SUCH_CATEGORY','No such a category %s was found.' );
define ( '_MD_D3BLOG_ERROR_NO_VIEWABLE_ENTRY','Sorry, No entry can be viewed.' );
define ( '_MD_D3BLOG_ERROR_NO_NUM_PER_PAGE','Number per page was illegal.' );
define ( '_MD_D3BLOG_ERROR_COM_USER_ID_INVALID', 'User id was illegal.' );
define ( '_MD_D3BLOG_ERROR_COM_TEXT_REQUIRED', 'Message is required.' );
define ( '_MD_D3BLOG_ERROR_COM_NAME_REQUIRED', 'Name is required.' );
define ( '_MD_D3BLOG_ERROR_COM_NAME_SIZEOVER', 'Name length exceeds %s bytes.' );
define ( '_MD_D3BLOG_ERROR_COM_EMAIL_REQUIRED', 'e-mail is required.' );
define ( '_MD_D3BLOG_ERROR_COM_EMAIL_SIZEOVER', 'e-mail length exceeds %s bytes.' );
define ( '_MD_D3BLOG_ERROR_COM_EMAIL_INVALID', 'Illega format of e-mail.' );
define ( '_MD_D3BLOG_ERROR_COM_URL_SIZEOVER', 'Url length exceeds %s bytes.' );
define ( '_MD_D3BLOG_ERROR_COM_NO_SUCH_COM','No such a comment was found.' );
define ( '_MD_D3BLOG_ERROR_COM_NO_SUCH_PARENT','No such a parent comment.' );
define ( '_MD_D3BLOG_ERROR_COM_NO_PERM_FOR_ENTRY', 'You have no privilege to post a comment to this entry.' );
define ( '_MD_D3BLOG_ERROR_COM_NO_PERM_FOR_EDIT', 'Comment are closed.' );
define ( '_MD_D3BLOG_ERROR_COM_NO_PERM_FOR_REPLY', 'You cannot reply this comment.' );
define ( '_MD_D3BLOG_ERROR_COM_NO_PERM_FOR_DELETE', 'You have no privilege to delete.' );
define ( '_MD_D3BLOG_ERROR_COM_DELETE_FAILURE', 'An server error occurred. Failed to delete comment. Call your admin.' );
define ( '_MD_D3BLOG_ERROR_COM_INVALID_ENTRY', 'Invalid entry.' );
define ( '_MD_D3BLOG_ERROR_COM_INVALID_PARENT', 'You cannot reply to this comment.' );
define ( '_MD_D3BLOG_ERROR_COM_UPDATE_FAILURE', 'Server error occurred. Failed to update a comment database. Call your admin.' );
// <--- FORMAT PROPERTY --->

// <--- PERMDESC PROPERTY --->

?>