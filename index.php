<?php

    // LISTE DES CONFIGURATIONS DU FRAMEWORK
	require_once './core/config.php';

	$request = new \ESMT\VLFramework\Request;
	$pArray = $request->sections();

	$section = $pArray[0];
    unset($pArray[0]);

    // Page d'accueil du site
	if ( $section == '' ) {
        (new Response())->render ( 'home.html', $request->get() );

	// ON REGARDE SI LA SECTION DEMANDEE EXISTE
	} else if ( in_array($section, $sections) ){

		// ON RECUPERE LA NOUVELLE URL DE LA SECTION
		$url = '/'.implode('/', $pArray);
		$urlsFilePath = './src/'.$section.'/urls.php';

		// SI LE FICHIER urls.php DE LA SECTION EXISTE
		if ( file_exists($urlsFilePath) ) {
            require $urlsFilePath;

            $found = false;

            // ON REGARDE SI LURL FAIT PARTIE DE LA LISTE DES URLS
            // ENUMEREES
            foreach ($urls as $path => $mtd) {
                $pattern = createPattern( $path );

                if ( preg_match( $pattern, $url, $params ) ){
                    unset($params[0]);
                    $found = true;
                    $method = $mtd;
                    break;
                }
            }

            // SI ON TROUVE UNE CORRESPONDANCE, ON RECUPERE LA METHODE
            // ACTION ET ON L'APPELLE
            if ( $found ) {
                $actionsFilePath = './src/'.$section.'/actions.php';

                //LE FICHIER actions.php EXISTE
                if (file_exists($actionsFilePath)) {
                    require $actionsFilePath;

                    $response = new Response;
                    $response->addTemplateDir ( './src/'.$section.'/templates' );

                    $action = new \ESMT\VLFramework\Action ( $request, $response );

                    if (count($params) > 0){
                        $method( $action, $params );

                    } else {
                        $method ( $action );
                    }

                    //LE FICHIER actions.php EST INTROUVABLE
                } else {
                    echo "Le fichier " .$actionsFilePath. " est introuvable";
                }

                // SI L'URL N'APPARTIENT PAS A LA SECTION
            } else {
                (new Response())->render ( '404.html' );
            }

            //LE FICHIER urls.php DE LA SECTION EST INTROUVABLE
        } else {
		    echo "Le fichier " . $urlsFilePath . " est introuvable !";
        }


	// SI LA SECTION N'EXISTE PAS ON AFFICHE UNE ERREUR
	} else {
        (new Response())->render ( '404.html' );
	}

	clearstatcache();