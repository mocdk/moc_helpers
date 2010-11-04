dispatcher = PAGE
dispatcher.config.disableAllHeaderCode = 1
[globalVar = GP:contenttype=xml]
dispatcher.config.additionalHeaders = Content-Type: text/xml
[end]
dispatcher.typeNum = 500
dispatcher.1 = USER_INT
dispatcher.1.includeLibs = EXT:moc_helpers/Classes/AjaxDispatcher.php
dispatcher.1.userFunc = Tx_MocHelpers_AjaxDispatcher->Dispatch

