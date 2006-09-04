<?php

require_once('XMLImport.php');
//require_once('ProgressBar.php');
//require_once('..\WiktionaryZ\Expression.php');

/*
 * Import Swiss-Prot from the XML file. Be sure to have started a transaction first!
 */
function importSwissProt($xmlFileName, $umlsCollectionId = 0, $goCollectionId = 0, $EC2GoMapping = array(), $keyword2GoMapping = array()) {
	// Create mappings from EC numbers and SwissProt keywords to GO term meaning id's:	
	$EC2GoMeaningId = array();
	$keyword2GoMeaningId = array();

	if ($goCollectionId != 0) {
		$goCollection = getCollectionContents($goCollectionId);
	
		foreach ($EC2GoMapping as $EC => $GO) {
			if (array_key_exists($GO, $goCollection)) {
				$goMeaningId = $goCollection[$GO];
				$EC2GoMeaningId[$EC] = $goMeaningId;
			}
		}
	
		foreach ($keyword2GoMapping as $keyword => $GO) {
			if (array_key_exists($GO, $goCollection)) {
				$goMeaningId = $goCollection[$GO];
				$keyword2GoMeaningId[$keyword] = $goMeaningId;
			}
		}
	}

	// SwissProt import:
	$numberOfBytes = filesize($xmlFileName);
	initializeProgressBar($numberOfBytes, 5000000);
	$fileHandle = fopen($xmlFileName, "r");
	importEntriesFromXMLFile($fileHandle, $umlsCollectionId, $EC2GoMeaningId, $keyword2GoMeaningId);

	fclose($fileHandle);	
}

function importEntriesFromXMLFile($fileHandle, $umlsCollectionId, $EC2GoMeaningIdMapping, $keyword2GoMeaningIdMapping) {
	$languageId = 85;
	$collectionId = bootstrapCollection("Swiss-Prot", $languageId, "");
	$classCollectionId = bootstrapCollection("Swiss-Prot classes", $languageId, "CLAS");
	$relationTypeCollectionId = bootstrapCollection("Swiss-Prot relation types", $languageId, "RELT");
	$textAttibuteCollectionId = bootstrapCollection("Swiss-Prot text attributes", $languageId, "TATT");
	$ECCollectionId = bootstrapCollection("Enzyme Commission numbers", $languageId, "");
	
	$xmlParser = new SwissProtXMLParser();
	$xmlParser->languageId = $languageId;
	$xmlParser->collectionId = $collectionId;
	$xmlParser->classCollectionId = $classCollectionId;
	$xmlParser->relationTypeCollectionId = $relationTypeCollectionId;
	$xmlParser->textAttibuteCollectionId = $textAttibuteCollectionId;
	$xmlParser->ECCollectionId = $ECCollectionId;
	$xmlParser->EC2GoMeaningIdMapping = $EC2GoMeaningIdMapping;
	$xmlParser->keyword2GoMeaningIdMapping = $keyword2GoMeaningIdMapping;
	
	// Find some UMLS concepts for cross references from SwissProt:
	if ($umlsCollectionId != 0) {
		$xmlParser->proteinConceptId = getCollectionMemberId($umlsCollectionId, "C0033684");
		$xmlParser->geneConceptId = getCollectionMemberId($umlsCollectionId, "C0017337");
		$xmlParser->organismConceptId = getCollectionMemberId($umlsCollectionId, "C0029235");
		$xmlParser->proteinFragmentConceptId = getCollectionMemberId($umlsCollectionId, "C1335533");
	}
	
	$xmlParser->initialize();
	
	parseXML($fileHandle, $xmlParser);
}

class SwissProtXMLParser extends BaseXMLParser {
	public $languageId;
	public $collectionId;
	public $classCollectionId;
	public $relationTypeCollectionId;
	public $textAttibuteCollectionId;
	public $ECCollectionId;
	public $EC2GoMeaningIdMapping;
	public $keyword2GoMeaningIdMapping;
	public $numberOfEntries = 0;
	
	public $proteins = array();
	public $species = array();
	public $genes = array();
	public $attributes = array();
	public $ECNumbers = array();
	
	public $proteinConceptId = 0;
	public $proteinFragmentConceptId = 0;
	public $organismSpecificProteinConceptId = 0;
	public $organismSpecificGeneId = 0;
	public $geneConceptId = 0;
	public $organismConceptId = 0;
	public $referencedByConceptId = 0;
	public $keywordConceptId = 0;
	public $includesConceptId = 0;
	public $includedInConceptId = 0;
	public $containsConceptId = 0;
	public $containedInConceptId = 0;
	public $textAttributeConceptId = 0;
	public $enzymeCommissionNumberConceptId = 0;
	public $activityConceptId = 0;
	
	protected function bootstrapDefinedMeaning($spelling, $definition) {
		$expression = $this->getOrCreateExpression($spelling);
		$definedMeaningId = createNewDefinedMeaning($expression->id, $this->languageId, $definition);

		return $definedMeaningId;
	}
	
	protected function bootstrapConceptIds() {
		if ($this->proteinConceptId == 0)
			$this->proteinConceptId = $this->bootstrapDefinedMeaning("protein", "protein");

		if ($this->proteinFragmentConceptId == 0)
			$this->proteinFragmentConceptId = $this->bootstrapDefinedMeaning("protein fragment", "protein fragment");
		
		if ($this->organismSpecificProteinConceptId == 0)
			$this->organismSpecificProteinConceptId = $this->bootstrapDefinedMeaning("organism specific protein", "organism specific protein");

		if ($this->organismSpecificGeneConceptId == 0)
			$this->organismSpecificGeneConceptId = $this->bootstrapDefinedMeaning("organism specific gene", "organism specific gene");
		
		if ($this->geneConceptId == 0)
			$this->geneConceptId = $this->bootstrapDefinedMeaning("gene", "gene");
		
		if ($this->organismConceptId == 0)
			$this->organismConceptId = $this->bootstrapDefinedMeaning("organism", "organism");
			
		if ($this->referencedByConceptId == 0)
			$this->referencedByConceptId = $this->bootstrapDefinedMeaning("referenced by", "referenced by");
		
		if ($this->keywordConceptId == 0)
			$this->keywordConceptId = $this->bootstrapDefinedMeaning("keyword", "keyword");
		
		if ($this->includesConceptId == 0)
			$this->includesConceptId = $this->bootstrapDefinedMeaning("includes", "includes");
		
		if ($this->includedInConceptId == 0)
			$this->includedInConceptId = $this->bootstrapDefinedMeaning("included in", "included in");
		
		if ($this->containsConceptId == 0)
			$this->containsConceptId = $this->bootstrapDefinedMeaning("contains", "contains");
		
		if ($this->containedInConceptId == 0)
			$this->containedInConceptId = $this->bootstrapDefinedMeaning("contained in", "contained in");
		
		if ($this->enzymeCommissionNumberConceptId == 0)
			$this->enzymeCommissionNumberConceptId = $this->bootstrapDefinedMeaning("enzyme commission number", "enzyme commission number");

		if ($this->textAttributeConceptId == 0)
			$this->textAttributeConceptId = $this->bootstrapDefinedMeaning("text attribute", "text attribute");

		if ($this->activityConceptId == 0)
			$this->activityConceptId = $this->bootstrapDefinedMeaning("activity", "activity");
	}
	
	public function initialize() {
		$this->bootstrapConceptIds();
		
		// Add concepts to classes
		addDefinedMeaningToCollectionIfNotPresent($this->proteinConceptId, $this->classCollectionId, "protein");
		addDefinedMeaningToCollectionIfNotPresent($this->proteinFragmentConceptId, $this->classCollectionId, "protein fragment");
		addDefinedMeaningToCollectionIfNotPresent($this->geneConceptId, $this->classCollectionId, "gene");
		addDefinedMeaningToCollectionIfNotPresent($this->organismConceptId, $this->classCollectionId, "organism");
		addDefinedMeaningToCollectionIfNotPresent($this->organismSpecificProteinConceptId, $this->classCollectionId, "organism specific protein");
		addDefinedMeaningToCollectionIfNotPresent($this->textAttributeConceptId, $this->classCollectionId, "text attribute");
		addDefinedMeaningToCollectionIfNotPresent($this->enzymeCommissionNumberConceptId, $this->classCollectionId, "enzyme commission number");
		
		// Add concepts to relation types
		addDefinedMeaningToCollectionIfNotPresent($this->proteinConceptId, $this->relationTypeCollectionId, "protein");
		addDefinedMeaningToCollectionIfNotPresent($this->referencedByConceptId, $this->relationTypeCollectionId, "referenced by");
		addDefinedMeaningToCollectionIfNotPresent($this->geneConceptId, $this->relationTypeCollectionId, "gene");
		addDefinedMeaningToCollectionIfNotPresent($this->organismConceptId, $this->relationTypeCollectionId, "organism");
		addDefinedMeaningToCollectionIfNotPresent($this->activityConceptId, $this->relationTypeCollectionId, "activity");
		addDefinedMeaningToCollectionIfNotPresent($this->keywordConceptId, $this->relationTypeCollectionId, "keyword");
		addDefinedMeaningToCollectionIfNotPresent($this->includesConceptId, $this->relationTypeCollectionId, "includes");
		addDefinedMeaningToCollectionIfNotPresent($this->includedInConceptId, $this->relationTypeCollectionId, "included in");
		addDefinedMeaningToCollectionIfNotPresent($this->containsConceptId, $this->relationTypeCollectionId, "contains");
		addDefinedMeaningToCollectionIfNotPresent($this->containedInConceptId, $this->relationTypeCollectionId, "contained in");
	}
	
	public function startElement($parser, $name, $attributes) {
		global
			$numberOfBytes;

		if (count($this->stack) == 0){
			$handler = new UniProtXMLElementHandler();
			$handler->name = $name;
			$handler->importer = $this;
			$handler->setAttributes($attributes);
			$this->stack[] = $handler;						
		}
		else {
			if (count($this->stack) == 1) {
				$currentByteIndex = xml_get_current_byte_index($parser);
				setProgressBarPosition($currentByteIndex);
			}
			
			BaseXMLParser::startElement($parser, $name, $attributes);
		}
	}
	
	public function import($entry){
		$proteinMeaningId = $this->addProtein($entry->protein);

		if ($entry->gene != "")
			$geneMeaningId = $this->addGene($entry->gene, $entry->geneSynonyms);
		else 
			$geneMeaningId = -1;
		
		$organismSpeciesMeaningId = $this->addOrganism($entry->organism, $entry->organismTranslations);
		
		$entryMeaningId = $this->addEntry($entry, $proteinMeaningId, $geneMeaningId, $organismSpeciesMeaningId);

		$this->numberOfEntries += 1;
//		echo "$this->numberOfEntries\n";
	}
	
	public function addProtein($protein){
		if (array_key_exists($protein->name, $this->proteins)) {
			$definedMeaningId = $this->proteins[$protein->name];
		}
		else {
			$definedMeaningId = $this->addExpressionAsDefinedMeaning($protein->name, $protein->name, $protein->name, $this->collectionId);
			$this->proteins[$protein->name] = $definedMeaningId;
		}
		
		if($protein->fragment) 
			addClassMembership($definedMeaningId, $this->proteinFragmentConceptId);
		else
			addClassMembership($definedMeaningId, $this->proteinConceptId);			
		
		return $definedMeaningId;
	}
	
	public function addGene($name, $synonyms) {
		if (array_key_exists($name, $this->genes)) {
			$definedMeaningId = $this->genes[$name];
		}
		else {
			$definedMeaningId = $this->addExpressionAsDefinedMeaning($name, $name, $name, $this->collectionId);
			$this->genes[$name] = $definedMeaningId;
		}
		
		addClassMembership($definedMeaningId, $this->geneConceptId);
		
		foreach ($synonyms as $key => $synonym) {
			addSynonymOrTranslation($synonym, $this->languageId, $definedMeaningId, true);
		}
		
		return $definedMeaningId;		
	}
	
	public function addOrganism($name, $translations) {
		if (array_key_exists($name, $this->species)) {
			$definedMeaningId = $this->species[$name];
		}
		else {
			$definedMeaningId = $this->addExpressionAsDefinedMeaning($name, $name, $name, $this->collectionId);
			$this->species[$name] = $definedMeaningId;
		}
		
		addClassMembership($definedMeaningId, $this->organismConceptId);
		
		foreach ($translations as $key => $translation) {
			addSynonymOrTranslation($translation, $this->languageId, $definedMeaningId, true);
		}
		
		return $definedMeaningId;		
	}
	
	public function addEntry($entry, $proteinMeaningId, $geneMeaningId, $organismSpeciesMeaningId) {
		// change name to make sure it works in wiki-urls:
		$swissProtExpression = str_replace('_', '-', $entry->name);
		$entryExpression = $entry->protein->name . ' in ' . $entry->organism;
		
		// add the expression as defined meaning:
		$expression = $this->getOrCreateExpression($entryExpression);
		$definedMeaningId = createNewDefinedMeaning($expression->id, $this->languageId, $entryExpression);
		addDefinedMeaningToCollection($definedMeaningId, $this->collectionId, $entry->accession);
		
		// Add entry synonyms: Swiss-Prot entry name and species specific protein synonyms		
		addSynonymOrTranslation($swissProtExpression, $this->languageId, $definedMeaningId, true);
		
		foreach ($entry->protein->synonyms as $key => $synonym) 
			addSynonymOrTranslation($synonym, $this->languageId, $definedMeaningId, true);

		// set the class of the entry:
		addClassMembership($definedMeaningId, $this->organismSpecificProteinConceptId);

		// set the protein of the swiss prot entry and relate the protein to the entry:		
		addRelation($definedMeaningId, $this->proteinConceptId, $proteinMeaningId);
		addRelation($proteinMeaningId, $this->referencedByConceptId, $definedMeaningId);

		// set the gene of the swiss prot entry and relate the gene to the entry:
		if($geneMeaningId >= 0) {
			addRelation($definedMeaningId, $this->geneConceptId, $geneMeaningId);
			addRelation($geneMeaningId, $this->referencedByConceptId, $definedMeaningId);
		}
		
		// set the species of the swiss prot entry and relate the species to the entry:		
		addRelation($definedMeaningId, $this->organismConceptId, $organismSpeciesMeaningId);
		addRelation($organismSpeciesMeaningId, $this->referencedByConceptId, $definedMeaningId);
		
		// add the comment fields as text attributes:
		foreach ($entry->comments as $key => $comment) {
			$attributeMeaningId = $this->getOrCreateAttributeMeaningId($comment->type);
			$textValue = $comment->text;
			
			if ($comment->status != "") 
				$textValue .= " (" . $comment->status . ")";
				
			addDefinedMeaningTextAttributeValue($definedMeaningId, $attributeMeaningId, $this->languageId, $textValue);
		}		
		
		// add EC number:
		if($entry->EC != ""){
			$ECNumberMeaningId = $this->getOrCreateECNumberMeaningId($entry->EC);
			addRelation($definedMeaningId, $this->activityConceptId, $ECNumberMeaningId);
			addRelation($ECNumberMeaningId, $this->referencedByConceptId, $definedMeaningId);
		}
		
		// add keywords:
		foreach ($entry->keywords as $key => $keyword) {
			if (array_key_exists($keyword, $this->keyword2GoMeaningIdMapping)) {
				$goMeaningId = $this->keyword2GoMeaningIdMapping[$keyword];
				addRelation($definedMeaningId, $this->keywordConceptId, $goMeaningId);
				addRelation($goMeaningId, $this->referencedByConceptId, $definedMeaningId);
			}
		}
		
 		// Add protein includes relations
		foreach ($entry->protein->domains as $key => $domain) {
			$domainMeaningId = $this->addProtein($domain);
			addRelation($definedMeaningId, $this->includesConceptId, $domainMeaningId);
			addRelation($domainMeaningId, $this->includedInConceptId, $definedMeaningId);
		}
		
 		// Add protein includes relations
		foreach ($entry->protein->components as $key => $component) {
			$componentMeaningId = $this->addProtein($component);
			addRelation($definedMeaningId, $this->containsConceptId, $componentMeaningId);
			addRelation($componentMeaningId, $this->containedInConceptId, $definedMeaningId);
		}
		
		return $definedMeaningId;		
	}
	
	public function getOrCreateAttributeMeaningId($attribute) {
		if (array_key_exists($attribute, $this->attributes)) {
			$definedMeaningId = $this->attributes[$attribute];
		}
		else {
			$definedMeaningId = $this->addExpressionAsDefinedMeaning($attribute, $attribute, $attribute, $this->textAttibuteCollectionId);
			addClassMembership($definedMeaningId, $this->textAttributeConceptId);
			$this->attributes[$attribute] = $definedMeaningId;
		}
		return $definedMeaningId;		
	}
	
	public function getOrCreateECNumberMeaningId($EC) {
		if (array_key_exists($EC, $this->ECNumbers)) {
			$definedMeaningId = $this->ECNumbers[$EC];
		}
		elseif (array_key_exists($EC, $this->EC2GoMeaningIdMapping)) {
			$definedMeaningId = $this->EC2GoMeaningIdMapping[$EC];
			$this->ECNumbers[$EC] = $definedMeaningId;
			$expression = $this->getOrCreateExpression($EC);
			$expression->assureIsBoundToDefinedMeaning($definedMeaningId, true);
		}
		else {
			$definedMeaningId = $this->addExpressionAsDefinedMeaning($EC, $EC, $EC, $this->ECCollectionId);
			addClassMembership($definedMeaningId, $this->enzymeCommissionNumberConceptId);
			$this->ECNumbers[$EC] = $definedMeaningId;
		}
		return $definedMeaningId;		
	}
	
	public function getOrCreateExpression($spelling) {
		$expression = findExpression($spelling, $this->languageId);
		if (!$expression) {
			$expression = createExpression($spelling, $this->languageId);
		}
		return $expression;		
	}
	
	public function addExpressionAsDefinedMeaning($spelling, $definition, $internalIdentifier, $collectionId) {
		$expression = $this->getOrCreateExpression($spelling);
		$definedMeaningId = createNewDefinedMeaning($expression->id, $this->languageId, $definition);
		addDefinedMeaningToCollection($definedMeaningId, $collectionId, $internalIdentifier);
		return $definedMeaningId;
	}
} 

class UniProtXMLElementHandler extends DefaultXMLElementHandler {
	public $importer;
	
	public function getHandlerForNewElement($name) {
		if($name=="ENTRY") {
			$result = new EntryXMLElementHandler();
		}
		else {
			$result = DefaultXMLElementHandler::getHandlerForNewElement($name);
		}
		$result->name = $name;
		return $result;
	}
	
	public function notify($childHandler) {
		if (is_a($childHandler, EntryXMLElementHandler)) {
			$this->importer->import($childHandler->entry);
		}
	}
}

class EntryXMLElementHandler extends DefaultXMLElementHandler {
	public $entry;

	public function __construct() {
		$this->entry = new SwissProtEntry();	
	}
	
	public function getHandlerForNewElement($name) {
		switch($name) {
			case "PROTEIN": 
				$result = new ProteinXMLElementHandler();
				break;
			case "GENE":
				$result = new GeneXMLElementHandler();
				break;
			case "ORGANISM":
				$result = new OrganismXMLElementHandler();
				break;
			case "COMMENT":
				$result = new CommentXMLElementHandler();
				break;
			default:
				$result = DefaultXMLElementHandler::getHandlerForNewElement($name);
				break;
		}
		
		$result->name = $name;
		
		return $result;
	}
	
	public function notify($childHandler) {
		if (is_a($childHandler, ProteinXMLElementHandler)) {
			$this->entry->protein = $childHandler->protein;		
		}
		elseif (is_a($childHandler, GeneXMLElementHandler)) {
//			$this->entry->gene = $childHandler->gene;
//			$this->entry->geneSynonyms = $childHandler->synonyms;
			list($this->entry->gene, $this->entry->geneSynonyms) = $childHandler->getResult();
		}
		elseif (is_a($childHandler, OrganismXMLElementHandler)) {
			$this->entry->organism = $childHandler->organism;
			$this->entry->organismTranslations = $childHandler->translations;		
		}
		elseif (is_a($childHandler, CommentXMLElementHandler)) {
			if ($childHandler->comment != "")
				$this->entry->comments[] = $childHandler->comment;
		}
		elseif($childHandler->name == "ACCESSION") {
			if ($this->entry->accession == "") {
				$this->entry->accession = $childHandler->data;
			} 
			else {
				$this->entry->secundaryAccessions[] = $childHandler->data;
			}
		}
		elseif($childHandler->name == "NAME") {
			$this->entry->name = $childHandler->data;
		}															 
		elseif($childHandler->name == "DBREFERENCE" && array_key_exists("TYPE", $childHandler->attributes) && $childHandler->attributes["TYPE"] == "EC"){
			$this->entry->EC = $childHandler->attributes["ID"];
		}
		elseif($childHandler->name == "KEYWORD") {
			$this->entry->keywords[] = $childHandler->attributes["ID"];
		}
	}	
}

class ProteinXMLElementHandler extends DefaultXMLElementHandler {
	public $protein;
	
	public function __construct() {
		$this->protein = new Protein();
	}
	
	public function setAttributes($attributes) {
		DefaultXMLElementHandler::setAttributes($attributes);
		$this->protein->fragment = (array_key_exists("TYPE", $this->attributes) && ($this->attributes["TYPE"] == "fragment" || $this->attributes["TYPE"] == "fragments"));
	} 
	
	public function getHandlerForNewElement($name) {
		if ($name == "NAME") 
			$result = new NameXMLElementHandler();
		else 
			$result = new ProteinXMLElementHandler();
		
		$result->name = $name;
		return $result;
	}
	
	public function notify($childHandler) {
		if (is_a($childHandler, NameXMLElementHandler)) {
			$proteinName = $childHandler->data;
			if ($this->protein->name == "") 
				$this->protein->name = $proteinName;
			else 
				$this->protein->synonyms[]=$proteinName;
		}
		elseif ($childHandler->name == "DOMAIN")
			$this->protein->domains[] = $childHandler->protein;					
		elseif ($childHandler->name == "COMPONENT")
			$this->protein->components[] = $childHandler->protein;					
	}
}

class NameXMLElementHandler extends DefaultXMLElementHandler {
	public $name;
	
	public function close() {
		$this->name = $this->data;
	}
}

class GeneNameXMLElementHandler extends DefaultXMLElementHandler {
	public $name = "";
	public $type = "";

	public function setAttributes($attributes) {
		$this->type = $attributes["TYPE"];	
	}

	public function processData($data) {
		$this->name .= $data;
	}
}

class GeneXMLElementHandler extends DefaultXMLElementHandler {
	public $primaryNames = array();
	public $synonyms = array();
	public $orderedLoci = array();
	public $ORFs = array();
	
	public function getHandlerForNewElement($name) {
		if ($name == "NAME")
			return new GeneNameXMLElementHandler();
		else
			return parent::getHandlerForNewElement($name);
	}
	
	public function notify($childHandler) {
		// We expect a GeneNameXMLElementHandler
		
		switch ($childHandler->type) { 
			case "primary": 
				$this->primaryNames[] = $childHandler->name;
				break;
			case "synonym":
				$this->synonyms[] = $childHandler->name;
				break;
			case "ordered locus":
				$this->orderedLoci[] = $childHandler->name;
				break;
			case "ORF":
				$this->ORFs[] = $childHandler->name;
				break;
		}	
	}
	
	public function getResult() {
		// Primary name is not always present for a gene, fall back to a synonym, ORF or ordered locus
		$name = "";
		$synonyms = array();
		
		foreach($this->primaryNames as $primaryName) 
			if ($name == "")
				$name = $primaryName;
			else
				$synonyms[] = $primaryName;
		
		foreach($this->synonyms as $synonym) 
			if ($name == "")
				$name = $synonym;
			else
				$synonyms[] = $synonym;
		
		foreach($this->ORFs as $ORF) 
			if ($name == "")
				$name = $ORF;
			else
				$synonyms[] = $ORF;
				
		foreach($this->orderedLoci as $orderedLocus) 
			if ($name == "")
				$name = $orderedLocus;
			else
				$synonyms[] = $orderedLocus;

		return array($name, $synonyms);
	}
}

class OrganismXMLElementHandler extends DefaultXMLElementHandler {
	public $organism = "";
	public $translations = array();
	
	public function notify($childHandler) {
		if ($childHandler->name == "NAME") {
			if($this->organism == "") 
				$this->organism = $childHandler->data; 
			else 
				$this->translations[] = $childHandler->data;	
		}
	}
}

class CommentXMLElementHandler extends DefaultXMLElementHandler {
	public $comment;
	
	public function __construct() {
		$this->comment = new Comment();
	}
	
	public function setAttributes($attributes) {
		DefaultXMLElementHandler::setAttributes($attributes);
		$this->comment->type = $attributes["TYPE"];
		
		if (array_key_exists("STATUS", $attributes))
			$this->comment->status = $attributes["STATUS"];
	} 
	
	public function notify($childHandler) {
		if ($childHandler->name = "TEXT")
			$this->comment->text = $childHandler->data;
	}
}

class SwissProtEntry {
	public $name = "";
	public $accession = "";
	public $secundaryAccessions = array();
	public $protein;
	public $EC = "";
	public $gene = "";
	public $geneSynonyms = array();
	public $organism = "";
	public $organismTranslations = array();
	public $comments = array();
	public $keywords = array();
}

class Comment {
	public $type = "";
	public $text = "";
	public $status = "";
}

class Protein {
	public $name = "";
	public $fragment = false;
	public $synonyms = array();
	public $domains = array();
	public $components = array();
	
//	public function __construct($nameSynonymsString) {
//		$openingBracketPosition = strpos($nameSynonymsString, "(");
//		if ($openingBracketPosition === false) {
//			$this->name = trim($nameSynonymsString);
//		}
//		else {
//			$this->name = trim(substr($nameSynonymsString, 0, $openingBracketPosition));
//			$nameSynonymsString = substr($nameSynonymsString, $openingBracketPosition, strlen($nameSynonymsString)-$openingBracketPosition);
//			$openingBracketPosition = strpos($nameSynonymsString, "(");
//		}
//		while($openingBracketPosition !== false) {
//			$closingBracketPosition = strpos($nameSynonymsString, ")");
//			$this->synonyms[]= trim(substr($nameSynonymsString, $openingBracketPosition+1, $closingBracketPosition - $openingBracketPosition-1));
//			$nameSynonymsString = substr($nameSynonymsString, $closingBracketPosition+1, strlen($nameSynonymsString)-$closingBracketPosition);
//			$openingBracketPosition = strpos($nameSynonymsString, "(");	
//		}	
//	}
}

//class SwissProtImportEntry {
//	public $attributes;
//	
//	public function __construct() {
//		$this->attributes = array();
//	}
//	
//	public function import($fileHandle){
//		$line = fgets($fileHandle);
//		while((!feof($fileHandle)) and (getPrefix($line) != "//")){
//			$attribute = $this->getEntryAttribute($line);
//			$line = $attribute->import($line, $fileHandle);
//		} 
//	}
//	
//	public function echoEntry(){
//		foreach ($this->attributes as $prefix => $attribute) {
//			foreach ($attribute->lines as $line) {
//				echo $line;					
//			}
//		}
//	}
//	
//	private function getEntryAttribute($line){
//    $line = rtrim($line,"\n");
//		$prefix = getPrefix($line);
//    if (!array_key_exists($prefix, $this->attributes)) {
//    	$this->attributes[$prefix]=new SwissProtEntryAttribute($prefix);	
//    }
//    return $this->attributes[$prefix]; 	    
//	}
//	
//	public function getIdentifier(){
//		$idAttribute = $this->attributes["ID"];
//		if ($idAttribute) {
//			$line = $idAttribute->lines[0];
//			$line = stripPrefix($line);
//			$endIdentifierPosition = strpos($line, " ");
//			return substr($line, 0, $endIdentifierPosition);				
//		}
//	}
//	
//	public function getDescriptionAttribute(){
//		$descriptionAttibute = $this->attributes["DE"];
//		if ($descriptionAttibute) {
//			return new DescriptionSwissProtEntryAttribute($descriptionAttibute);
//		}
//	}
//}
//
//function getPrefix($line) {
//	return substr($line, 0, 2);			
//}
//
//function stripPrefix($line) {
//	$line = substr($line, 2, strlen($line)-2);		
//	return ltrim($line);
//}
//
//function joinLinesWithoutPrefixes($attribute) {
//	$result = "";
//	foreach ($attribute->lines as $line) {
//		$unPrefixedLine = stripPrefix($line);
//		$unPrefixedLine = rtrim($unPrefixedLine,"\n");
//		$result .= $unPrefixedLine;  
//	}
//	return $result;
//}
//
//class SwissProtEntryAttribute {
//	public $prefix;
//	public $lines;
//
//	public function __construct($prefix) {
//		$this->prefix = $prefix;
//		$this->lines = array();
//	}
//	
//	public function import($firstLine, $fileHandle){
//		$this->lines[]=$firstLine;
//		$line = fgets($fileHandle);
//					
//		while ( (!feof($fileHandle)) and ( (getPrefix($line) == $this->prefix) or (getPrefix($line) == "  ") )){
//			$this->lines[]=$line;								
//			$line = fgets($fileHandle);
//		}
//		return $line; 
//	}
//}
//
//class DescriptionSwissProtEntryAttribute {
//	private $attribute;
//	private $includesString;
//	private $containsString;
//	public $protein;
//	public $containsProteins;
//	public $includesProteins;
//	public $isFragment;
//	
//	public function __construct($attribute) {
//		$this->attribute = $attribute;
//		$this->parse();
//	}
//	
//	public function parse() {
//		$fullDescription = rtrim(joinLinesWithoutPrefixes($this->attribute), ".");
//		$fragmentPosition = strpos($fullDescription, "(Fragment");
//					
//		if ($this->isFragment = ($fragmentPosition!==false)) {
//			$fullDescription = rtrim(substr($fullDescription, 0, $fragmentPosition));
//		}
//				
//		$startContainsPosition = strpos($fullDescription, "[Contains:");
//		$startIncludesPosition = strpos($fullDescription, "[Includes:");
//		
//		if (($startContainsPosition!==false) or ($startIncludesPosition!==false)) {
//			$endProteinPosition = max($startContainsPosition, $startIncludesPosition);
//			$this->getContainsAndIncludesStrings($fullDescription, $startContainsPosition, $startIncludesPosition);
//		}
//		else {
//			$endProteinPosition = strlen($fullDescription);
//		}  
//		$proteinString = rtrim(substr($fullDescription, 0, $endProteinPosition));
//		$this->protein = new Protein($proteinString);
//	}
//	
//	private function getContainsAndIncludesStrings($fullDescription, $startContainsPosition, $startIncludesPosition) {
//			if ($startContainsPosition===false) {
//				$startContainsPosition = strlen($fullDescription);
//			}
//			if ($startIncludesPosition===false) {
//				$startIncludesPosition = strlen($fullDescription);
//			}
//			
//			if ($startContainsPosition > $startIncludesPosition) {
//				$endIncludesPosition = strpos($fullDescription, "]");
//				$endContainsPosition = strpos($fullDescription, "]", $endIncludesPosition+1);
//			}
//			else {
//				$endContainsPosition = strpos($fullDescription, "]");
//				$endIncludesPosition = strpos($fullDescription, "]", $endContainsPosition+1);
//			}
//			$this->includesString = trim(substr($fullDescription, $startIncludesPosition + 10, $endIncludesPosition-$startIncludesPosition-10));
//			$this->containsString = trim(substr($fullDescription, $startContainsPosition + 10, $endContainsPosition-$startContainsPosition-10));
//	}
//}

?>
