<?php
// Classe Router pour capter l'URL demandée et charger le bon contrôleur
class Router {
    // Tableau qui stocke toutes les routes enregistrées (GET et POST)
    private array $routes = [];

    // Enregistre une route accessible via la méthode HTTP GET
    public function get(string $path, string $controller, string $method): void {
    	$this->routes['GET'][$path] = compact('controller', 'method');
    }

    // Enregistre une route accessible via la méthode HTTP POST
    public function post(string $path, string $controller, string $method): void{
    	$this->routes['POST'][$path] = compact('controller', 'method');
    }

    // Analyse l'URL actuelle du navigateur pour exécuter la bonne action
    public function dispatch(): void {
    $httpMethod = $_SERVER['REQUEST_METHOD']; // Récupère la méthode (GET ou POST)
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // Récupère le chemin dans l'URL
    	
    // Nettoie l'URL pour enlever le dossier racine du projet (/pressing3/public)
    $base = '/pressing3/public'; 
    if (str_starts_with($uri, $base)) {
        $uri = substr($uri, strlen($base)); 
    }
    $uri = '/' . trim($uri, '/'); 
    if ($uri === '') $uri = '/';
    	
    // Si l'URL demandée existe dans les routes, on l'exécute
    if(isset($this->routes[$httpMethod][$uri])){
   	$this->call($this->routes[$httpMethod][$uri]); return;
    }
    
    // Si l'URL n'existe pas, renvoie une erreur 404 (Page non trouvée)
    http_response_code(404);
    echo "Page introuvable : $uri";
}

    // Inclut le fichier du contrôleur et appelle sa méthode correspondante
    private function call(array $target, array $params = []): void {
    $file = BASE_PATH . '/app/controllers/' . $target['controller'] . '.php'; // Chemin du contrôleur
    	
    // Arrête le script si le fichier du contrôleur n'existe pas
    if (!file_exists($file)) {
        die("Contrôleur introuvable : " . $target['controller']);
    }
    	
    require_once $file; // Inclut le fichier du contrôleur
    	
   $ctrl = new $target['controller'](); // Crée une instance du contrôleur
   call_user_func_array([$ctrl, $target['method']], $params); // Déclenche la fonction demandée
}


}