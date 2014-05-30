function MY_url()
{
	this.urlString = null;
	this.isHTTP = null;
	this.isWWW = null;
	
	/**
	 * Extract hash
	 *
	 * For parsing variable hash in to several parts that we need
	 * By each menu
	 *
	 * @param		request			string		request type that we want (all, menu, form-input, list-shortcuts)
	 */
	this.extractHash = function(request)
	{
		// console.log(url);
		
	};
	
	/**
	 * Get Class Controller
	 *
	 * For get class name at file controller
	 * Parsing from urlString with several steps ::
	 * 		1. Replace string base url
	 *		2. Replace character "#" (usually for showing part at view)
	 *		3. Parsing with other function at these class
	 */
	this.getClassController = function()
	{
		var classController = urlString.replace(SITE_URL + "/", ""); // remove base url
		
		// Check whether is there character "#"
		// If there is then replace character & string after that
		if(classController.lastIndexOf('#') !== -1){
			classController = classController.substring(0, classController.lastIndexOf('#') + 1); // remove string after character #
			classController = classController.replace("#", ""); // remove character # for showing part at view (id at tagHTML)
		}
		
		classController = classController.split("/"); // parsing with other function at these class
		return classController[0];
	};
	
	/**
	 * Get URL Controller
	 *
	 * Get URL only part of controller (either class or function)
	 * But with replacing URL from base url
	 */
	this.getURLController = function()
	{
		var urlController = urlString.replace(SITE_URL, "");
		return urlController;
	};
	
	/**
	 * Get URL Header
	 *
	 * Get URL from header browser
	 */
	this.getURLHeader = function()
	{
		return window.location.href;
	};
	
	/**
	 * Get URL String
	 *
	 * Get URL from variable on this class
	 */
	this.getURLString = function()
	{
		return urlString;
	};
	
	/**
	 * Set URL String
	 *
	 * Set URL for variable on this class
	 */
	this.setURLString = function(url)
	{
		urlString = url;
	};
	
	/**
	 * Update URL Header
	 *
	 * Change URL at header browser
	 */
	this.updateURLHeader = function()
	{
		// Update URL Browser
		var stateObj = { foo: "bar" };
		history.pushState(stateObj, "page 2", urlString);
	};
	
	/**
	 * URL Check
	 *
	 * Check URL, whether opened appropriate with hash tag that there is at URL
	 * If not then program will show home
	 */
	this.urlCheck = function(url, hash)
	{
		console.log(url);
		console.log(hash);
		console.log(SITE_URL);
		
		var g = url.split("/");
		console.log(g);
	};
	
}