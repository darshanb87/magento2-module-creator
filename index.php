<?php
/**
 * Magento 2 Module Creator
 * @version    0.1
 */

$root = substr($_SERVER['SCRIPT_FILENAME'], 0, strrpos($_SERVER['SCRIPT_FILENAME'], '/') + 1);
$shop = null;

function copyBlankoFiles($from, $to, $shop = null) {
    global $root;
    if (!is_array($from)) {
        $from = array($from);
    }
    if (!is_array($to)) {
        $to = array($to);
    }
    if ($shop === null) {
        $shop = $root . 'new/';
        if (!is_dir($shop)) {
            mkdir($shop);
        }
    }
    if (count($from) !== count($to)) {
        throw new Exception('Count of from -> to files do not match.');
    }
    foreach ($to as $file) {
        $newPath = substr($file, 0, strrpos($file, '/'));
        createFolderPath($newPath, $shop);
    }
    for ($i = 0; $i < count($to); $i++) {
        if (copy($root.$from[$i], $shop.$to[$i]) === false) {
            throw new Exception('Could not copy blanko files.');
        }
    }
    return true;
}

function createFolderPath($paths, $shop = null) {
    global $root;
    if (!is_array($paths)) {
        $paths = array($paths);
    }
    if ($shop === null) {
        $shop = $root;
    }
    foreach ($paths as $path) {
        $folders = explode('/', $path);
        $current = '';
        
        foreach ($folders as $folder) {
            $fp = $current . DIRECTORY_SEPARATOR . $folder;
            if (!is_dir($shop.$fp)) {
                if (mkdir($shop.$fp) === false) {
                    throw new Exception('Could not create new path: '. $shop.$fp);
                }
            }
            $current = $fp;
        }
    }
    return true;
}

function insertCustomVars($files, $shop = null) {
    global $root, $capModule, $lowModule, $isSystem, $typeData, $labelData, $codeData;

    if (!is_array($files)) {
        $files = array($files);
    }
    if ($shop === null) {
        $shop = $root . 'new'.DIRECTORY_SEPARATOR;
    }
    
    foreach ($files as $file) {
        $handle = fopen ($shop.$file, 'r+');
        $content = '';
        while (!feof($handle)) {
            $content .= fgets($handle);
        }
        fclose($handle);
        
        $type = strrchr($file, '.');
        switch ($type) {
            case '.xml':
                $content = replaceXml($content);
                break;
            case '.php':
            case '.csv':
            case '.phtml':
                $content = replacePhp($content);
                break;
            default:
                throw new Exception('Unknown file type found: '.$type);
        }
        $handle = fopen ($shop.$file, 'w');
        fputs($handle, $content);    
        fclose($handle);
        
        $filename = basename($shop.$file);
    }
}

function replacePhp($content)
{
    global $capNamespace, $lowNamespace, $capModule, $lowModule;
    
    $search = array(
                    '/<Namespace>/',
                    '/<namespace>/',
                    '/<Module>/',
                    '/<module>/',
                    );
    
    $replace = array(
                    $capNamespace,
                    $lowNamespace,
                    $capModule,
                    $lowModule,
                    );
    
    return preg_replace($search, $replace, $content);
}

function replaceXml($content)
{
    global $capNamespace, $lowNamespace, $capModule, $lowModule, $tabLabel, $sectionLabel, $groupCode, $groupLabel;
        
    $search = array(
                    '/\[Namespace\]/',
                    '/\[namespace\]/',
                    '/\[Module\]/',
                    '/\[module\]/',
                    '/\[tab_label\]/',
                    '/\[section_label\]/',
                    '/\[group_code\]/',
                    '/\[group_label\]/',
                    );
                    
    $replace = array(
                    $capNamespace,
                    $lowNamespace,
                    $capModule,
                    $lowModule,
                    $tabLabel,
                    $sectionLabel,
                    $groupCode,
                    $groupLabel
                    );
    
    return preg_replace($search, $replace, $content);
}

$ns = isset($_POST['namespace']) ? $_POST['namespace']:'';
$mod = isset($_POST['module']) ? $_POST['module']:'';

if(!empty($_POST)) {
    $namespace = $_POST['namespace'];
    $module = $_POST['module'];
    $capNamespace = ucfirst($namespace);
    $lowNamespace = strtolower($namespace);
    $capModule = ucfirst($module);
    $lowModule = strtolower($module);
    
    $fromFiles = array(
						'blank/app/code/Namespace/Module/registration.php',
                        'blank/app/code/Namespace/Module/Block/Module.php',
                        'blank/app/code/Namespace/Module/Block/View.php',
                        'blank/app/code/Namespace/Module/Block/Adminhtml/Module.php',
                        'blank/app/code/Namespace/Module/Block/Adminhtml/Module/Edit.php',
                        'blank/app/code/Namespace/Module/Block/Adminhtml/Module/Grid.php',
                        'blank/app/code/Namespace/Module/Block/Adminhtml/Module/Edit/Form.php',
                        'blank/app/code/Namespace/Module/Block/Adminhtml/Module/Edit/Tabs.php',
                        'blank/app/code/Namespace/Module/Block/Adminhtml/Module/Edit/Tab/Content.php',
                        'blank/app/code/Namespace/Module/Block/Adminhtml/Module/Edit/Tab/Image.php',
                        'blank/app/code/Namespace/Module/Block/Adminhtml/Module/Edit/Tab/Main.php',
                        'blank/app/code/Namespace/Module/Block/Adminhtml/Form/Element/Image.php',
                        'blank/app/code/Namespace/Module/Controller/ModuleInterface.php',
                        'blank/app/code/Namespace/Module/Controller/Index/Index.php',
                        'blank/app/code/Namespace/Module/Controller/Index/View.php',
                        'blank/app/code/Namespace/Module/Controller/AbstractController/ModuleLoader.php',
                        'blank/app/code/Namespace/Module/Controller/AbstractController/ModuleLoaderInterface.php',
                        'blank/app/code/Namespace/Module/Controller/AbstractController/View.php',
                        'blank/app/code/Namespace/Module/Controller/Adminhtml/Index/Delete.php',
                        'blank/app/code/Namespace/Module/Controller/Adminhtml/Index/Edit.php',
                        'blank/app/code/Namespace/Module/Controller/Adminhtml/Index/Grid.php',
                        'blank/app/code/Namespace/Module/Controller/Adminhtml/Index/Index.php',
                        'blank/app/code/Namespace/Module/Controller/Adminhtml/Index/NewAction.php',
                        'blank/app/code/Namespace/Module/Controller/Adminhtml/Index/PostDataProcessor.php',
                        'blank/app/code/Namespace/Module/Controller/Adminhtml/Index/Save.php',
                        'blank/app/code/Namespace/Module/etc/acl.xml',
                        'blank/app/code/Namespace/Module/etc/config.xml',
                        'blank/app/code/Namespace/Module/etc/module.xml',
                        'blank/app/code/Namespace/Module/etc/adminhtml/menu.xml',
                        'blank/app/code/Namespace/Module/etc/adminhtml/routes.xml',
                        'blank/app/code/Namespace/Module/etc/adminhtml/system.xml',
                        'blank/app/code/Namespace/Module/etc/frontend/di.xml',
                        'blank/app/code/Namespace/Module/etc/frontend/routes.xml',
                        'blank/app/code/Namespace/Module/Helper/Data.php',
                        'blank/app/code/Namespace/Module/i18n/en_US.csv',
                        'blank/app/code/Namespace/Module/Model/Module.php',
                        'blank/app/code/Namespace/Module/Model/ResourceModel/Module.php',
                        'blank/app/code/Namespace/Module/Model/ResourceModel/Module/Collection.php',
                        'blank/app/code/Namespace/Module/Setup/InstallSchema.php',
                        'blank/app/code/Namespace/Module/view/adminhtml/layout/module_index_edit.xml',
                        'blank/app/code/Namespace/Module/view/adminhtml/layout/module_index_grid.xml',
                        'blank/app/code/Namespace/Module/view/adminhtml/layout/module_index_index.xml',
                        'blank/app/code/Namespace/Module/view/adminhtml/layout/module_index_new.xml',
                        'blank/app/code/Namespace/Module/view/frontend/layout/default.xml',
                        'blank/app/code/Namespace/Module/view/frontend/layout/module_index_index.xml',
                        'blank/app/code/Namespace/Module/view/frontend/layout/module_index_view.xml',
                        'blank/app/code/Namespace/Module/view/frontend/templates/module.phtml',
                        'blank/app/code/Namespace/Module/view/frontend/templates/view.phtml',
                        );

    $toFiles = array(
						'app/code/'.$capNamespace.'/'.$capModule.'/registration.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Block/'.$capModule.'.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Block/View.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Block/Adminhtml/'.$capModule.'.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Block/Adminhtml/'.$capModule.'/Edit.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Block/Adminhtml/'.$capModule.'/Grid.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Block/Adminhtml/'.$capModule.'/Edit/Form.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Block/Adminhtml/'.$capModule.'/Edit/Tabs.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Block/Adminhtml/'.$capModule.'/Edit/Tab/Content.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Block/Adminhtml/'.$capModule.'/Edit/Tab/Image.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Block/Adminhtml/'.$capModule.'/Edit/Tab/Main.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Block/Adminhtml/Form/Element/Image.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Controller/'.$capModule.'Interface.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Controller/Index/Index.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Controller/Index/View.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Controller/AbstractController/'.$capModule.'Loader.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Controller/AbstractController/'.$capModule.'LoaderInterface.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Controller/AbstractController/View.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Controller/Adminhtml/Index/Delete.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Controller/Adminhtml/Index/Edit.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Controller/Adminhtml/Index/Grid.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Controller/Adminhtml/Index/Index.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Controller/Adminhtml/Index/NewAction.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Controller/Adminhtml/Index/PostDataProcessor.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Controller/Adminhtml/Index/Save.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/etc/acl.xml',
                        'app/code/'.$capNamespace.'/'.$capModule.'/etc/config.xml',
                        'app/code/'.$capNamespace.'/'.$capModule.'/etc/module.xml',
                        'app/code/'.$capNamespace.'/'.$capModule.'/etc/adminhtml/menu.xml',
                        'app/code/'.$capNamespace.'/'.$capModule.'/etc/adminhtml/routes.xml',
                        'app/code/'.$capNamespace.'/'.$capModule.'/etc/adminhtml/system.xml',
                        'app/code/'.$capNamespace.'/'.$capModule.'/etc/frontend/di.xml',
                        'app/code/'.$capNamespace.'/'.$capModule.'/etc/frontend/routes.xml',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Helper/Data.php',
						'app/code/'.$capNamespace.'/'.$capModule.'/i18n/en_US.csv',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Model/'.$capModule.'.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Model/ResourceModel/'.$capModule.'.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/Model/ResourceModel/'.$capModule.'/Collection.php',
						'app/code/'.$capNamespace.'/'.$capModule.'/Setup/InstallSchema.php',
                        'app/code/'.$capNamespace.'/'.$capModule.'/view/adminhtml/layout/'.$lowModule.'_index_edit.xml',
                        'app/code/'.$capNamespace.'/'.$capModule.'/view/adminhtml/layout/'.$lowModule.'_index_grid.xml',
                        'app/code/'.$capNamespace.'/'.$capModule.'/view/adminhtml/layout/'.$lowModule.'_index_index.xml',
                        'app/code/'.$capNamespace.'/'.$capModule.'/view/adminhtml/layout/'.$lowModule.'_index_new.xml',
                        'app/code/'.$capNamespace.'/'.$capModule.'/view/frontend/layout/default.xml',
                        'app/code/'.$capNamespace.'/'.$capModule.'/view/frontend/layout/'.$lowModule.'_index_index.xml',
                        'app/code/'.$capNamespace.'/'.$capModule.'/view/frontend/layout/'.$lowModule.'_index_view.xml',
                        'app/code/'.$capNamespace.'/'.$capModule.'/view/frontend/templates/'.$lowModule.'.phtml',
                        'app/code/'.$capNamespace.'/'.$capModule.'/view/frontend/templates/view.phtml',
                        );
    
     if ($_POST['create']) {
         if (!empty($module) && !empty($namespace)) {
             copyBlankoFiles($fromFiles, $toFiles, $shop);
             insertCustomVars($toFiles, $shop);
            
             $message = '<div id="message"><p><strong>New Module successfully created!</strong></p>
                <ul>
                <li>You\'ll find a new folder called <strong>\'new\'</strong>. Go to the folder where news files are located.</li>
                <li>This folder has the same structure as your Magento 2 Installation.</li>
				<li>Create a "code" folder inside your_magento_webroot/app folder.</li>
				<li>Put this Module inside "code" folder like app/code/Namespace/Modulename</li>
				<li>execute command "php magento setup:upgrade" from your_magento_webroot/bin directory</li>
                <li>Implement your module functionality and you\'re done!</li>
                </ul>';
            $message .= '</div>';
         } else {
             $message = '<div id="message"><p>Please fill out the required fields.</p></div>';
         }
     }
} else {
    $message = '<div id="message">
	This module creator script will save magento developers time which helps in providing estimation of custom module development.<br/>
	To create a new module for Magento 2, insert Namespace and a Module name (e.g. Blog, Forum, etc.) below. <br/>
	This script will create module which has basic folders, required PHP and XML files, frontend listing and view, backend listing and view according to Magento 2 structure and coding standards.<br/>
	You can later start work by keeping/adding/removing/changing files according to your requirement.
    </div>';
}
include('form.php');