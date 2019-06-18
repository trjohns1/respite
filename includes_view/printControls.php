<?php

// ****************************************************************************************************
// printControlLabelOnly
// ****************************************************************************************************
// Generates the HTML necessary to create a label only with no associated input fields.
// Useful when including multiple input fields stacked together, esp. checkboxes

function printControlLabelOnly($label='', $helperText='') {
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}


// ****************************************************************************************************
// printControlText
// ****************************************************************************************************
// Generates the HTML necessary to create a type="text" form input control.

function printControlText($name, $view, $label='', $helperText='', $dirtyFlag='') {
   $dirty = ''; // javascript tag to prevent navigation away from an altered but unsaved form
   if($dirtyFlag == 'dirty') {
      $dirty = ' onchange="respiteDirty()"';
   }
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";
   echo '      <input type="text" name="' . $name . '"' . $dirty . ' value="' . (isset($view['formData'][$name]) ? $view['formData'][$name] : '') . '"/>' . "\n";
   if(isset($view['errors'][$name])) {
      echo '      <p class="error">' . $view['errors'][$name] . '</p>' . "\n";
   }
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}

// ****************************************************************************************************
// printControlPassword
// ****************************************************************************************************
// Generates the HTML necessary to create a type="password" form input control.

function printControlPassword($name, $view, $label='', $helperText='', $dirtyFlag='') {
   $dirty = ''; // javascript tag to prevent navigation away from an altered but unsaved form
   if($dirtyFlag == 'dirty') {
      $dirty = ' onchange="respiteDirty()"';
   }
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";
   echo '      <input type="password" name="' . $name . '"' . $dirty . ' value="' . (isset($view['formData'][$name]) ? $view['formData'][$name] : '') . '"/>' . "\n";
   if(isset($view['errors'][$name])) {
      echo '      <p class="error">' . $view['errors'][$name] . '</p>' . "\n";
   }
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}


// ****************************************************************************************************
// printControlTextarea
// ****************************************************************************************************
// Generates the HTML necessary to create a textarea form input control.

function printControlTextArea($name, $view, $label='', $helperText='', $dirtyFlag='') {
   $dirty = ''; // javascript tag to prevent navigation away from an altered but unsaved form
   if($dirtyFlag == 'dirty') {
      $dirty = ' onchange="respiteDirty()"';
   }
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";
   echo '      <textarea name="' . $name . '"' . ' class="longText"' . $dirty . '>' . (isset($view['formData'][$name]) ? $view['formData'][$name] : '') . '</textarea>' . "\n";
   if(isset($view['errors'][$name])) {
      echo '      <p class="error">' . $view['errors'][$name] . '</p>' . "\n";
   }
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}

// ****************************************************************************************************
// printControlCheckbox
// ****************************************************************************************************
// Generates the HTML necessary to create a type="checkbox" form input control.

function printControlCheckbox($name, $view, $boxLabel='', $label='', $helperText='', $dirtyFlag='') {
   $dirty = ''; // javascript tag to prevent navigation away from an altered but unsaved form
   if($dirtyFlag == 'dirty') {
      $dirty = ' onchange="respiteDirty()"';
   }
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";

   echo '      <label class="checkboxLabel"><input type="checkbox" name="' . $name . '" value="' . $view['validCheckFields'][$name] . '"' . $dirty . ' ' . (isset($view['formData'][$name]) ? $view['formData'][$name] : '') . '/>' . $boxLabel . '</label>' . "\n";
   if(isset($view['errors'][$name])) {
      echo '      <p class="error">' . $view['errors'][$name] . '</p>' . "\n";
   }
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}

// ****************************************************************************************************
// printControlSelect
// ****************************************************************************************************
// Generates the HTML necessary to create a select list form input control.

function printControlSelect($name, $view, $label='', $helperText='', $dirtyFlag='') {
   $dirty = ''; // javascript tag to prevent navigation away from an altered but unsaved form
   if($dirtyFlag == 'dirty') {
      $dirty = ' onchange="respiteDirty()"';
   }
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";
   echo '      <select name="' . $name . '"' . $dirty . '>' . "\n";

   foreach($view['validSelectFields'][$name] as $key=>$value) {
      echo '         <option value="' . $value . '" ' . (isset($view['formData'][$key]) ? $view['formData'][$key] : '') . '>' . $view['labels'][$name][$key] . '</option>' . "\n";
   }
   echo '      </select>' . "\n";
   if(isset($view['errors'][$name])) {
      echo '      <p class="error">' . $view['errors'][$name] . '</p>' . "\n";
   }
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}


// ****************************************************************************************************
// printControlSelectMulti
// ****************************************************************************************************
// Generates the HTML necessary to create a multiple selection list form input control.

function printControlSelectMulti($name, $view, $label='', $helperText='', $dirtyFlag='') {
   $dirty = ''; // javascript tag to prevent navigation away from an altered but unsaved form
   if($dirtyFlag == 'dirty') {
      $dirty = ' onchange="respiteDirty()"';
   }
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";

   echo '      <select name="' . $name . '[]" multiple="multiple"' . $dirty . '>' . "\n";
   foreach($view['validSelectMultiFields'][$name] as $key=>$value) {
      echo '         <option value="' . $value . '" ' . (isset($view['formData'][$key]) ? $view['formData'][$key] : '') . '>' . $view['labels'][$name][$key] . '</option>' . "\n";
   }

   echo '      </select>' . "\n";
   if(isset($view['errors'][$name])) {
      echo '      <p class="error">' . $view['errors'][$name] . '</p>' . "\n";
   }
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}


// ****************************************************************************************************
// printControlRadio
// ****************************************************************************************************
// Generates the HTML necessary to create a radio button form input control.

function printControlRadio($name, $view, $label='', $helperText='', $dirtyFlag='') {
   $dirty = ''; // javascript tag to prevent navigation away from an altered but unsaved form
   if($dirtyFlag == 'dirty') {
      $dirty = ' onchange="respiteDirty()"';
   }
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";
   foreach($view['validRadioFields'][$name] as $key=>$value) {
      echo '         <label class="radioLabel"><input type="radio" name="' . $name . '" value="' . $view['validRadioFields'][$name][$key] . '"' . $dirty . ' ' . (isset($view['formData'][$key]) ? $view['formData'][$key] : '') . '/>' . $view['labels'][$name][$key] . '</label>' . "\n";
   }
   if(isset($view['errors'][$name])) {
      echo '      <p class="error">' . $view['errors'][$name] . '</p>' . "\n";
   }
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}


// ****************************************************************************************************
// printControlFile
// ****************************************************************************************************
// Generates the HTML necessary to create a type="file" form input control.

function printControlFile($name, $view, $label='', $helperText='', $dirtyFlag='') {
   $dirty = ''; // javascript tag to prevent navigation away from an altered but unsaved form
   if($dirtyFlag == 'dirty') {
      $dirty = ' onchange="respiteDirty()"';
   }
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";
   echo '      <input type="file" name="' . $name . '"' . $dirty . '/>' . "\n";
   if(isset($view['errors'][$name])) {
      echo '      <p class="error">' . $view['errors'][$name] . '</p>' . "\n";
   }
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}


// ****************************************************************************************************
// printControlColor
// ****************************************************************************************************
// Generates the HTML necessary to create a type="color" form input control.

function printControlColor($name, $view, $label='', $helperText='', $dirtyFlag='') {
   $dirty = ''; // javascript tag to prevent navigation away from an altered but unsaved form
   if($dirtyFlag == 'dirty') {
      $dirty = ' onchange="respiteDirty()"';
   }
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";

   echo '      <input type="color" name="' . $name . '" value="' . (isset($view['formData'][$name]) ? $view['formData'][$name] : '') . '"' . $dirty . '/>' . "\n";
   if(isset($view['errors'][$name])) {
      echo '      <p class="error">' . $view['errors'][$name] . '</p>' . "\n";
   }
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}


// ****************************************************************************************************
// printControlDate
// ****************************************************************************************************
// Generates the HTML necessary to create a type="date" form input control.

function printControlDate($name, $view, $label='', $helperText='', $dirtyFlag='') {
   $dirty = ''; // javascript tag to prevent navigation away from an altered but unsaved form
   if($dirtyFlag == 'dirty') {
      $dirty = ' onchange="respiteDirty()"';
   }
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";

   echo '      <input type="date" name="' . $name . '" value="' . (isset($view['formData'][$name]) ? $view['formData'][$name] : '') . '"' . $dirty . '/>' . "\n";
   if(isset($view['errors'][$name])) {
      echo '      <p class="error">' . $view['errors'][$name] . '</p>' . "\n";
   }
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}


// ****************************************************************************************************
// printControlDatetime
// ****************************************************************************************************
// Generates the HTML necessary to create a type="datetime" form input control.

function printControlDatetime($name, $view, $label='', $helperText='', $dirtyFlag='') {
   $dirty = ''; // javascript tag to prevent navigation away from an altered but unsaved form
   if($dirtyFlag == 'dirty') {
      $dirty = ' onchange="respiteDirty()"';
   }
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";
   echo '      <input type="datetime" name="' . $name . '" value="' . (isset($view['formData'][$name]) ? $view['formData'][$name] : '') . '"' . $dirty . '/>' . "\n";
   if(isset($view['errors'][$name])) {
      echo '      <p class="error">' . $view['errors'][$name] . '</p>' . "\n";
   }
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}


// ****************************************************************************************************
// printControlDatetimeLocal
// ****************************************************************************************************
// Generates the HTML necessary to create a type="datetime-local" form input control.

 function printControlDatetimeLocal($name, $view, $label='', $helperText='', $dirtyFlag='') {
   $dirty = ''; // javascript tag to prevent navigation away from an altered but unsaved form
   if($dirtyFlag == 'dirty') {
      $dirty = ' onchange="respiteDirty()"';
   }
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";
   echo '      <input type="datetime-local" name="' . $name . '" value="' . (isset($view['formData'][$name]) ? $view['formData'][$name] : '') . '"' . $dirty . '/>' . "\n";
   if(isset($view['errors'][$name])) {
      echo '      <p class="error">' . $view['errors'][$name] . '</p>' . "\n";
   }
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}


// ****************************************************************************************************
// printControlEmail
// ****************************************************************************************************
// Generates the HTML necessary to create a type="email" form input control.

 function printControlEmail($name, $view, $label='', $helperText='', $dirtyFlag='') {
   $dirty = ''; // javascript tag to prevent navigation away from an altered but unsaved form
   if($dirtyFlag == 'dirty') {
      $dirty = ' onchange="respiteDirty()"';
   }
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";
   echo '      <input type="email" name="' . $name . '" value="' . (isset($view['formData'][$name]) ? $view['formData'][$name] : '') . '"' . $dirty . '/>' . "\n";
   if(isset($view['errors'][$name])) {
      echo '      <p class="error">' . $view['errors'][$name] . '</p>' . "\n";
   }
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}


// ****************************************************************************************************
// printControlMonth
// ****************************************************************************************************
// Generates the HTML necessary to create a type="month" form input control.

 function printControlMonth($name, $view, $label='', $helperText='', $dirtyFlag='') {
   $dirty = ''; // javascript tag to prevent navigation away from an altered but unsaved form
   if($dirtyFlag == 'dirty') {
      $dirty = ' onchange="respiteDirty()"';
   }
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";
   echo '      <input type="month" name="' . $name . '" value="' . (isset($view['formData'][$name]) ? $view['formData'][$name] : '') . '"' . $dirty . '/>' . "\n";
   if(isset($view['errors'][$name])) {
      echo '      <p class="error">' . $view['errors'][$name] . '</p>' . "\n";
   }
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}



// ****************************************************************************************************
// printControlNumber
// ****************************************************************************************************
// Generates the HTML necessary to create a type="number" form input control.

 function printControlNumber($name, $view, $label='', $helperText='', $dirtyFlag='') {
   $dirty = ''; // javascript tag to prevent navigation away from an altered but unsaved form
   if($dirtyFlag == 'dirty') {
      $dirty = ' onchange="respiteDirty()"';
   }
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";
   echo '      <input type="number" name="' . $name . '" value="' . (isset($view['formData'][$name]) ? $view['formData'][$name] : '') . '"' . $dirty . '/>' . "\n";
   if(isset($view['errors'][$name])) {
      echo '      <p class="error">' . $view['errors'][$name] . '</p>' . "\n";
   }
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}


// ****************************************************************************************************
// printControlRange
// ****************************************************************************************************
// Generates the HTML necessary to create a type="range" form input control.

 function printControlRange($name, $view, $label='', $helperText='', $dirtyFlag='') {
   $dirty = ''; // javascript tag to prevent navigation away from an altered but unsaved form
   if($dirtyFlag == 'dirty') {
      $dirty = 'onchange="respiteDirty()"';
   }
   // build a string to represent value, which cannot be "" in a range control
   $value = '';
   if(isset($view['formData'][$name])) {
      $value = 'value="' . $view['formData'][$name] . '" ';
   }
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";
   echo '      <input type="range" name="' . $name . '" ' . $value . $dirty . '/>' . "\n";
   if(isset($view['errors'][$name])) {
      echo '      <p class="error">' . $view['errors'][$name] . '</p>' . "\n";
   }
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}


// ****************************************************************************************************
// printControlSearch
// ****************************************************************************************************
// Generates the HTML necessary to create a type="search" form input control.

 function printControlSearch($name, $view, $label='', $helperText='', $dirtyFlag='') {
   $dirty = ''; // javascript tag to prevent navigation away from an altered but unsaved form
   if($dirtyFlag == 'dirty') {
      $dirty = ' onchange="respiteDirty()"';
   }
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";
   echo '      <input type="search" name="' . $name . '" value="' . (isset($view['formData'][$name]) ? $view['formData'][$name] : '') . '"' . $dirty . '/>' . "\n";
   if(isset($view['errors'][$name])) {
      echo '      <p class="error">' . $view['errors'][$name] . '</p>' . "\n";
   }
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}


// ****************************************************************************************************
// printControlTel
// ****************************************************************************************************
// Generates the HTML necessary to create a type="tel" form input control.

 function printControlTel($name, $view, $label='', $helperText='', $dirtyFlag='') {
   $dirty = ''; // javascript tag to prevent navigation away from an altered but unsaved form
   if($dirtyFlag == 'dirty') {
      $dirty = ' onchange="respiteDirty()"';
   }
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";
   echo '      <input type="tel" name="' . $name . '" value="' . (isset($view['formData'][$name]) ? $view['formData'][$name] : '') . '"' . $dirty . '/>' . "\n";
   if(isset($view['errors'][$name])) {
      echo '      <p class="error">' . $view['errors'][$name] . '</p>' . "\n";
   }
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}


// ****************************************************************************************************
// printControlTime
// ****************************************************************************************************
// Generates the HTML necessary to create a type="time" form input control.

 function printControlTime($name, $view, $label='', $helperText='', $dirtyFlag='') {
   $dirty = ''; // javascript tag to prevent navigation away from an altered but unsaved form
   if($dirtyFlag == 'dirty') {
      $dirty = ' onchange="respiteDirty()"';
   }
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";
   echo '      <input type="time" name="' . $name . '" value="' . (isset($view['formData'][$name]) ? $view['formData'][$name] : '') . '"' . $dirty . '/>' . "\n";
   if(isset($view['errors'][$name])) {
      echo '      <p class="error">' . $view['errors'][$name] . '</p>' . "\n";
   }
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}


// ****************************************************************************************************
// printControlURL
// ****************************************************************************************************
// Generates the HTML necessary to create a type="url" form input control.

 function printControlURL($name, $view, $label='', $helperText='', $dirtyFlag='') {
   $dirty = ''; // javascript tag to prevent navigation away from an altered but unsaved form
   if($dirtyFlag == 'dirty') {
      $dirty = ' onchange="respiteDirty()"';
   }
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";
   echo '      <input type="url" name="' . $name . '" value="' . (isset($view['formData'][$name]) ? $view['formData'][$name] : '') . '"' . $dirty . '/>' . "\n";
   if(isset($view['errors'][$name])) {
      echo '      <p class="error">' . $view['errors'][$name] . '</p>' . "\n";
   }
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}


// ****************************************************************************************************
// printControlWeek
// ****************************************************************************************************
// Generates the HTML necessary to create a type="week" form input control.

 function printControlWeek($name, $view, $label='', $helperText='', $dirtyFlag='') {
   $dirty = ''; // javascript tag to prevent navigation away from an altered but unsaved form
   if($dirtyFlag == 'dirty') {
      $dirty = ' onchange="respiteDirty()"';
   }
   echo "\n";
   echo '<div class="group_item">' . "\n";
   echo '   <div class="GroupLeft">' . "\n";
   echo '      <label>' . $label . '</label>' . "\n";
   echo '      <p class="helper_text">' . $helperText . '</p>' . "\n";
   echo '   </div>' . "\n";
   echo '   <div class="GroupRight">' . "\n";
   echo '      <input type="week" name="' . $name . '" value="' . (isset($view['formData'][$name]) ? $view['formData'][$name] : '') . '"' . $dirty . '/>' . "\n";
   if(isset($view['errors'][$name])) {
      echo '      <p class="error">' . $view['errors'][$name] . '</p>' . "\n";
   }
   echo '   </div>' . "\n";
   echo '</div>' . "\n";
   echo '<div class="group_item_close"></div>' . "\n";
}

// ****************************************************************************************************
// printControlHidden
// ****************************************************************************************************
// Generates the HTML necessary to create a type="hidden" form input control.

function printControlHidden($name, $view) {
   echo '<input type="hidden" name="' . $name . '"' . ' value="' . (isset($view['formData'][$name]) ? $view['formData'][$name] : '') . '"/>' . "\n";
}

?>

