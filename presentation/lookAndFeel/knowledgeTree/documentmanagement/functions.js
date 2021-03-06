




var msie5 = (navigator.userAgent.indexOf('MSIE 5') != -1);

//************************************************************
// Folder content
var isSelected = false;

function toggleSelect(toggleSelectButton, selectAllText, deselectAllText) {
  formElements = toggleSelectButton.form.elements;

  if (isSelected) {
    for (i = 0; i < formElements.length; i++) {
      formElements[i].checked = false;
    }
    isSelected = false;
    toggleSelectButton.value = selectAllText;
  } else {
    for (i = 0; i < formElements.length; i++) {
      formElements[i].checked = true;
    }
    isSelected = true;
    toggleSelectButton.value = deselectAllText;
  }
}

//************************************************************
/**
 * Toggles an element's visibility.
 * Function to show tooltips.
 * If your element is a span, you must use inline display instead of block
 * XXX recognize div and span then automaticly choose the best display rule
 */
function toggleElementVisibility(id) {
  element = document.getElementById(id);
  if (element) {
    //window.alert(element.tagName)
    if (element.style.visibility == 'hidden') {
      element.style.visibility = 'visible';
      if (element.tagName == 'DIV') {
        element.style.display = 'block';
      } else if (element.tagName == 'SPAN') {
        element.style.display = 'inline';
      } else {
        element.style.display = 'block';
      }
    } else {
      element.style.visibility = 'hidden';
      element.style.display = 'none';
    }
  }
}

/**
 * Makes visible or hide an element given its ID.
 */
function showElement(show, id) {
  element = document.getElementById(id);
  if (element) {
    //window.alert(element.tagName)
    if (show) {
      element.style.visibility = 'visible';
      if (element.tagName in ['DIV', 'P']) {
        element.style.display = 'block';
      } else {
        element.style.display = 'inline';
      }
    } else {
      element.style.visibility = 'hidden';
      element.style.display = 'none';
    }
  }
}

//************************************************************
/**
 * Removes empty spaces at the beginning and end of the given string.
 */
function trim(s) {
  if (s) {
    return s.replace(/^\s*|\s*$/g, "");
  }
  return "";
}

//************************************************************
/**
 * Opens a link in a new window.
 * Returns false to prevent the browser from following the actual href.
 *
 * cf. http://openweb.eu.org/articles/popup/
 */
function openLinkInPopup(url) {
    // Call to prototype lib
    var dimension = Element.getDimensions(document.body);
    var height = dimension.height;
    var width = dimension.width;
    newWindow = window.open(url, 'cps_popup',
                            'height=' + height + ',width=' + width + ',resizable=yes,menubar=yes');
    if (window.focus) {
        newWindow.focus();
    }
    return false;
}

//************************************************************
/**
 * XXX ?
 */
function checkEmptySearch(formElem) {
  var query = trim(formElem.SearchableText.value);
  if (query != '') {
    formElem.SearchableText.value = query;
    return true;
  }
  formElem.SearchableText.value = query;
  formElem.SearchableText.focus();
  return false;
}

//************************************************************
/**
 * Sets focus on <input> elements that have a class attribute
 * containing the class 'focus'.
 * Examples:
 * <input type="text" id="username" name="__ac_name" class="focus"/>
 * <input type="text" id="searchableText" class="standalone giant focus"/>
 *
 * This function does not work on crappy MSIE5.0 and MSIE5.5.
 */
function setFocus() {
  if (msie5) {
    return false;
  }
  var elements = document.getElementsByTagName('input');
  for (var i = 0; i < elements.length; i++) {
    var nodeClass = elements[i].getAttributeNode('class');
    //alert("nodeClass = " + nodeClass);
    if (nodeClass) {
      var classes = nodeClass.value.split(' ');
      for (var j = 0; j < classes.length; j++) {
        if (classes[j] == 'focus') {
          elements[i].focus();
          return true;
        }
      }
    }
  }
}

/**
 * Validates that the input fields designated by the given ids are not empty.
 * It returns true if all the input fields are not empty, it returns false
 * otherwise.
 * Example:
 * <form onsubmit="return validateRequiredFields(['field1', 'field2'],
 * ['Title', 'Comments'], 'are empty while they are required fields.')">
 */
function validateRequiredFields(fieldIds, fieldLabels, informationText) {
  for (i = 0; i < fieldIds.length; i++) {
    element = document.getElementById(fieldIds[i]);
    if (element && !element.value) {
      window.alert("'" + fieldLabels[i] + "' " + informationText);
      return false;
    }
  }
  return true;
}

//************************************************************
/**
 * XXX ?
 */
function getSelectedRadio(buttonGroup) {
  if (buttonGroup[0]) {
    for (var i=0; i<buttonGroup.length; i++) {
      if (buttonGroup[i].checked) {
        return i
      }
    }
  } else {
    if (buttonGroup.checked) { return 0; }
  }
  return -1;
}

/**
 * XXX ?
 */
function getSelectedRadioValue(buttonGroup) {
  var i = getSelectedRadio(buttonGroup);
  if (i == -1) {
    return "";
  } else {
    if (buttonGroup[i]) {
    return buttonGroup[i].value;
    } else {
    return buttonGroup.value;
    }
  }
}

/**
 * XXX ?
 */
function getSelectedRadioId(buttonGroup) {
  var i = getSelectedRadio(buttonGroup);
  if (i == -1) {
    return "";
  } else {
    if (buttonGroup[i]) {
      return buttonGroup[i].id;
    } else {
      return buttonGroup.id;
    }
  }
}

/**
 * Return the label content corresponding to a radio selection
 */
function getSelectedRadioLabel(buttonGroup) {
  var id = getSelectedRadioId(buttonGroup);
  if (id == "") {
    return "";
  } else {
    for (var i=0; i<document.getElementsByTagName("label").length; i++) {
      var element_label = document.getElementsByTagName("label")[i];
      if (element_label.htmlFor == id) {
        return element_label.firstChild.nodeValue;
      }
    }
  }
}


//************************************************************
/**
 * Highlights the searched terms.
 *
 * From Geir B�kholt, adapted for CPS
 */
function highlightSearchTerm() {
  var query_elem = document.getElementById('searchGadget')
  if (! query_elem){
    return false
  }
  var query = query_elem.value
  // _robert_ ie 5 does not have decodeURI
  if (typeof decodeURI != 'undefined'){
    query = unescape(decodeURI(query)) // thanks, Casper
  }
  else {
    return false
  }
  if (query){
    queries = query.replace(/\+/g,' ').split(/\s+/)
    // make sure we start the right place and not higlight menuitems or breadcrumb
    searchresultnode = document.getElementById('searchResults')
    if (searchresultnode) {
      for (q=0;q<queries.length;q++) {
        // don't highlight reserved catalog search terms
        if (queries[q].toLowerCase() != 'not'
          && queries[q].toLowerCase() != 'and'
          && queries[q].toLowerCase() != 'or') {
          climb(searchresultnode,queries[q]);
        }
      }
    }
  }
}

function climb(node, word){
  // traverse childnodes
  if (! node){
    return false
  }
  if (node.hasChildNodes) {
    var i;
    for (i=0;i<node.childNodes.length;i++) {
      climb(node.childNodes[i],word);
    }
    if (node.nodeType == 3) {
      checkforhighlight(node, word);
      // check all textnodes. Feels inefficient, but works
    }
  }
}

function checkforhighlight(node,word) {
  ind = node.nodeValue.toLowerCase().indexOf(word.toLowerCase())
  if (ind != -1) {
    if (node.parentNode.className != "highlightedSearchTerm"){
      par = node.parentNode;
      contents = node.nodeValue;
      // make 3 shiny new nodes
      hiword = document.createElement("span");
      hiword.className = "highlightedSearchTerm";
      hiword.appendChild(document.createTextNode(contents.substr(ind,word.length)));
      par.insertBefore(document.createTextNode(contents.substr(0,ind)),node);
      par.insertBefore(hiword,node);
      par.insertBefore(document.createTextNode( contents.substr(ind+word.length)),node);
      par.removeChild(node);
    }
  }
}

/************************************************************
/**
 * searchLanguage widget functions
 * used to auto select languages checkbox/radio
 * cf CPSSchemas/skins/cps_schemas/widget_searchlanguage_render.pt
 */
function searchLanguageCheckSelected(languages, no_language, language) {
  var count=0;
  for (var i=0; i<languages.length; i++) {
    if (languages[i].checked) {
      count++;
    }
  }
  no_language.checked = (count <= 0);
  language.checked = (count > 0);
}

function searchLanguageClearSelected(languages) {
  for (i=0; i<languages.length; i++) {
    languages[i].checked = 0;
  }
}

function toggleLayers(more_block, more_items) {
  var objMoreBlock = document.getElementById(more_block).style;
  var objMoreItems = document.getElementById(more_items).style;
  if(objMoreBlock.display == "block")
    objMoreBlock.display = "none";
  if(objMoreItems.display == "none")
    objMoreItems.display = "block";
}
