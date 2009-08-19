/*
Copyright © 2003,
Center for Intelligent Information Retrieval,
University of Massachusetts, Amherst.
All rights reserved.

Redistribution and use in source and binary forms, with or without modification,
are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this
list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice,
this list of conditions and the following disclaimer in the documentation
and/or other materials provided with the distribution.

3. The names "Center for Intelligent Information Retrieval" and
"University of Massachusetts" must not be used to endorse or promote products
derived from this software without prior written permission. To obtain
permission, contact info@ciir.cs.umass.edu.

THIS SOFTWARE IS PROVIDED BY UNIVERSITY OF MASSACHUSETTS AND OTHER CONTRIBUTORS
"AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS OR CONTRIBUTORS BE
LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
SUCH DAMAGE.
*/
/* This is a java version of Bob Krovetz' KStem.
 *
 * Java version by Sergio Guzman-Lara.
 * CIIR-UMass Amherst http://ciir.cs.umass.edu
 */
package org.apache.lucene.analysis;

/** A list of words used by Kstem
 */
public class KStemData7 {
    private KStemData7() {
    }
   static String[] data = {
"rupee","rupture","rural","ruritanian","ruse",
"rush","rushes","rushlight","rusk","russet",
"rust","rustic","rusticate","rustication","rustle",
"rustler","rustless","rustling","rustproof","rusty",
"rut","ruthless","rutting","rye","sabbatarian",
"sabbath","sabbatical","saber","sable","sabot",
"sabotage","saboteur","sabra","sabre","sac",
"saccharin","saccharine","sacerdotal","sacerdotalism","sachet",
"sack","sackbut","sackcloth","sacral","sacrament",
"sacramental","sacred","sacrifice","sacrificial","sacrilege",
"sacrilegious","sacristan","sacristy","sacroiliac","sacrosanct",
"sad","sadden","saddle","saddlebag","saddler",
"saddlery","sadducee","sadhu","sadism","sadly",
"sadomasochism","safari","safe","safebreaker","safeguard",
"safekeeping","safety","saffron","sag","saga",
"sagacious","sagacity","sagebrush","sago","sahib",
"said","sail","sailcloth","sailing","sailor",
"sailplane","saint","sainted","saintly","saith",
"sake","saki","salaam","salable","salacious",
"salacity","salad","salamander","salami","salaried",
"salary","sale","saleable","saleroom","sales",
"salesclerk","salesgirl","saleslady","salesman","salesmanship",
"salient","saliferous","salify","saline","salinometer",
"saliva","salivary","salivate","sallow","sally",
"salmon","salmonella","salon","saloon","salsify",
"salt","saltcellar","saltire","saltlick","saltpan",
"saltpeter","saltpetre","salts","saltshaker","saltwater",
"salty","salubrious","salutary","salutation","salute",
"salvage","salvation","salvationist","salve","salvedge",
"salver","salvia","salvo","samaritan","samaritans",
"samba","same","sameness","samovar","sampan",
"sample","sampler","samurai","sanatorium","sanctify",
"sanctimonious","sanction","sanctities","sanctity","sanctuary",
"sanctum","sanctus","sand","sandal","sandalwood",
"sandbag","sandbank","sandbar","sandblast","sandbox",
"sandboy","sandcastle","sander","sandglass","sandman",
"sandpaper","sandpiper","sandpit","sands","sandshoe",
"sandstone","sandstorm","sandwich","sandy","sane",
"sang","sangfroid","sangria","sanguinary","sanguine",
"sanitary","sanitation","sanitorium","sanity","sank",
"sans","sanskrit","sap","sapience","sapient",
"sapless","sapling","sapper","sapphic","sapphire",
"sappy","sapwood","saraband","sarabande","sarcasm",
"sarcastic","sarcophagus","sardine","sardonic","sarge",
"sari","sarky","sarong","sarsaparilla","sartorial",
"sash","sashay","sass","sassafras","sassy",
"sat","satan","satanic","satanism","satchel",
"sate","sateen","satellite","satiable","satiate",
"satiety","satin","satinwood","satiny","satire",
"satirical","satirise","satirize","satisfaction","satisfactory",
"satisfy","satisfying","satrap","satsuma","saturate",
"saturation","saturday","saturn","saturnalia","saturnine",
"satyr","sauce","saucepan","saucer","saucy",
"sauerkraut","sauna","saunter","saurian","sausage",
"sauterne","sauternes","savage","savagery","savanna",
"savannah","savant","save","saveloy","saver",
"saving","savings","savior","saviour","savor",
"savory","savour","savoury","savoy","savvy",
"saw","sawbones","sawbuck","sawdust","sawhorse",
"sawmill","sawpit","sawyer","saxifrage","saxon",
"saxophone","saxophonist","say","saying","scab",
"scabbard","scabby","scabies","scabious","scabrous",
"scads","scaffold","scaffolding","scalar","scalawag",
"scald","scalding","scale","scalene","scallion",
"scallop","scallywag","scalp","scalpel","scaly",
"scamp","scamper","scampi","scan","scandal",
"scandalise","scandalize","scandalmonger","scandalous","scandinavian",
"scanner","scansion","scant","scanty","scapegoat",
"scapegrace","scapula","scar","scarab","scarce",
"scarcely","scarcity","scare","scarecrow","scared",
"scaremonger","scarf","scarify","scarlet","scarp",
"scarper","scary","scat","scathing","scatology",
"scatter","scatterbrain","scatterbrained","scattered","scatty",
"scavenge","scavenger","scenario","scenarist","scene",
"scenery","sceneshifter","scenic","scent","scepter",
"sceptic","sceptical","scepticism","sceptre","schedule",
"schema","schematic","schematize","scheme","scherzo",
"schism","schismatic","schist","schizoid","schizophrenia",
"schizophrenic","schmaltz","schmalz","schnapps","schnitzel",
"schnorkel","scholar","scholarly","scholarship","scholastic",
"scholasticism","school","schoolboy","schoolhouse","schooling",
"schoolman","schoolmarm","schoolmaster","schoolmastering","schoolmate",
"schoolwork","schooner","schwa","sciatic","sciatica",
"science","scientific","scientist","scientology","scimitar",
"scintilla","scintillate","scion","scissor","scissors",
"sclerosis","scoff","scold","scollop","sconce",
"scone","scoop","scoot","scooter","scope",
"scorbutic","scorch","scorcher","scorching","score",
"scoreboard","scorebook","scorecard","scorekeeper","scoreless",
"scorer","scorn","scorpio","scorpion","scotch",
"scoundrel","scoundrelly","scour","scourer","scourge",
"scout","scoutmaster","scow","scowl","scrabble",
"scrag","scraggly","scraggy","scram","scramble",
"scrap","scrapbook","scrape","scraper","scrapings",
"scrappy","scraps","scratch","scratchpad","scratchy",
"scrawl","scrawny","scream","screamingly","scree",
"screech","screed","screen","screening","screenplay",
"screw","screwball","screwdriver","screwy","scribble",
"scribbler","scribe","scrimmage","scrimp","scrimshank",
"scrimshaw","scrip","script","scripted","scriptural",
"scripture","scriptwriter","scrivener","scrofula","scrofulous",
"scroll","scrollwork","scrooge","scrotum","scrounge",
"scrub","scrubber","scrubby","scruff","scruffy",
"scrum","scrumcap","scrumhalf","scrummage","scrumptious",
"scrumpy","scrunch","scruple","scrupulous","scrutineer",
"scrutinise","scrutinize","scrutiny","scuba","scud",
"scuff","scuffle","scull","scullery","scullion",
"sculptor","sculptural","sculpture","scum","scupper",
"scurf","scurrility","scurrilous","scurry","scurvy",
"scut","scutcheon","scuttle","scylla","scythe",
"sea","seabed","seabird","seaboard","seaborne",
"seafaring","seafood","seafront","seagirt","seagoing",
"seagull","seahorse","seakale","seal","sealer",
"sealing","sealskin","sealyham","seam","seaman",
"seamanlike","seamanship","seamstress","seamy","seaplane",
"seaport","sear","search","searching","searchlight",
"searing","seascape","seashell","seashore","seasick",
"seaside","season","seasonable","seasonal","seasoning",
"seat","seating","seawall","seaward","seawards",
"seawater","seaway","seaweed","seaworthy","sec",
"secateurs","secede","secession","seclude","secluded",
"seclusion","seclusive","second","secondary","seconds",
"secrecy","secret","secretarial","secretariat","secretary",
"secrete","secretion","secretive","sect","sectarian",
"section","sectional","sectionalism","sector","secular",
"secularise","secularism","secularize","secure","security",
"sedan","sedate","sedation","sedative","sedentary",
"sedge","sediment","sedimentary","sedimentation","sedition",
"seditious","seduce","seduction","seductive","sedulous",
"see","seed","seedbed","seedcake","seedling",
"seedsman","seedy","seeing","seek","seem",
"seeming","seemingly","seemly","seen","seep",
"seepage","seer","seersucker","seesaw","seethe",
"segment","segmentation","segregate","segregated","segregation",
"seigneur","seine","seismic","seismograph","seismology",
"seize","seizure","seldom","select","selection",
"selective","selector","selenium","self","selfish",
"selfless","selfsame","sell","seller","sellotape",
"selvage","selves","semantic","semantics","semaphore",
"semblance","semeiology","semen","semester","semibreve",
"semicircle","semicolon","semiconductor","semidetached","semifinal",
"semifinalist","seminal","seminar","seminarist","seminary",
"semiology","semiprecious","semiquaver","semitic","semitone",
"semitropical","semivowel","semiweekly","semolina","sempstress",
"sen","senate","senator","senatorial","send",
"sender","senescence","senescent","seneschal","senile",
"senility","senior","seniority","senna","sensation",
"sensational","sensationalism","sense","senseless","senses",
"sensibility","sensible","sensitise","sensitive","sensitivity",
"sensitize","sensor","sensory","sensual","sensualist",
"sensuality","sensuous","sent","sentence","sententious",
"sentient","sentiment","sentimental","sentimentalise","sentimentalism",
"sentimentality","sentimentalize","sentinel","sentry","sepal",
"separable","separate","separation","separatism","separator",
"sepia","sepoy","sepsis","september","septet",
"septic","septicaemia","septicemia","septuagenarian","septuagesima",
"septuagint","sepulcher","sepulchral","sepulchre","sequel",
"sequence","sequencing","sequent","sequential","sequester",
"sequestrate","sequestration","sequin","sequoia","seraglio",
"seraph","seraphic","sere","serenade","serendipity",
"serene","serf","serfdom","serge","sergeant",
"serial","serialise","serialize","seriatim","sericulture",
"series","serif","seriocomic","serious","seriously",
"sermon","sermonise","sermonize","serous","serpent",
"serpentine","serrated","serried","serum","serval",
"servant","serve","server","servery","service",
"serviceable","serviceman","serviette","servile","serving",
"servitor","servitude","servomechanism","servomotor","sesame",
"session","sessions","set","setback","setscrew",
"setsquare","sett","settee","setter","setting",
"settle","settled","settlement","settler","seven",
"seventeen","seventy","sever","several","severally",
"severance","severity","sew","sewage","sewer",
"sewerage","sewing","sex","sexagenarian","sexagesima",
"sexism","sexist","sexless","sextant","sextet",
"sexton","sextuplet","sexual","sexuality","sexy",
"sforzando","sgt","shabby","shack","shackle",
"shad","shade","shades","shading","shadow",
"shadowbox","shadowy","shady","shaft","shag",
"shagged","shaggy","shagreen","shah","shake",
"shakedown","shaker","shakes","shako","shaky",
"shale","shall","shallop","shallot","shallow",
"shallows","shalom","shalt","sham","shaman",
"shamble","shambles","shame","shamefaced","shameful",
"shameless","shammy","shampoo","shamrock","shandy",
"shanghai","shank","shantung","shanty","shantytown",
"shape","shaped","shapely","shard","share",
"sharecropper","shareholder","shark","sharkskin",
"sharp","sharpen","sharpener","sharper","sharpshooter",
"shatter","shave","shaver","shaving","shawl",
"shay","she","sheaf","shear","shears",
"sheath","sheathe","sheathing","shebang","shebeen",
"shed","sheen","sheep","sheepdip","sheepdog",
"sheepfold","sheepish","sheepskin","sheer","sheet",
"sheeting","sheik","sheikdom","sheikh","sheikhdom",
"sheila","shekels","shelduck","shelf","shell",
"shellac","shellacking","shellfish","shellshock","shelter",
"sheltered","shelve","shelves","shelving","shenanigan",
"shepherd","shepherdess","sheraton","sherbet","sherd",
"sheriff","sherpa","sherry","shew","shh",
"shibboleth","shield","shift","shiftless","shifty",
"shilling","shimmer","shin","shinbone","shindig",
"shindy","shine","shiner","shingle","shingles",
"shining","shinny","shinto","shiny","ship",
"shipboard","shipbroker","shipbuilding","shipmate","shipment",
"shipper","shipping","shipshape","shipwreck","shipwright",
"shipyard","shire","shires","shirk","shirring",
"shirt","shirtfront","shirting","shirtsleeve","shirttail",
"shirtwaist","shirtwaister","shirty","shit","shits",
"shitty","shiver","shivers","shivery","shoal",
"shock","shocker","shockheaded","shocking","shockproof",
"shod","shoddy","shoe","shoeblack","shoehorn",
"shoelace","shoemaker","shoeshine","shoestring","shone",
"shoo","shook","shoot","shop","shopkeeper",
"shoplift","shopsoiled","shopworn","shore","shorn",
"short","shortage","shortbread","shortcake","shortcoming",
"shorten","shortening","shortfall","shorthand","shorthanded",
"shorthorn","shortie","shortly","shorts","shortsighted",
"shorty","shot","shotgun","should","shoulder",
"shouldst","shout","shouting","shove","shovel",
"shovelboard","show","showboat","showcase","showdown",
"shower","showery","showgirl","showing","showman",
"showmanship","shown","showpiece","showplace","showroom",
"showy","shrank","shrapnel","shred","shredder",
"shrew","shrewd","shrewish","shriek","shrift",
"shrike","shrill","shrimp","shrine","shrink",
"shrinkage","shrive","shrivel","shroud","shrub",
"shrubbery","shrug","shuck","shucks","shudder",
"shuffle","shuffleboard","shufty","shun","shunt",
"shunter","shush","shut","shutdown","shutter",
"shuttle","shuttlecock","shy","shyster","sibilant",
"sibling","sibyl","sibylline","sic","sick",
"sickbay","sickbed","sicken","sickening","sickle",
"sickly","sickness","sickroom","side","sidearm",
"sideboard","sideboards","sidecar","sidekick","sidelight",
"sideline","sidelong","sidereal","sidesaddle","sideshow",
"sideslip","sidesman","sidesplitting","sidestep","sidestroke",
"sideswipe","sidetrack","sidewalk","sideward","sidewards",
"sideways","siding","sidle","siege","sienna",
"sierra","siesta","sieve","sift","sifter",
"sigh","sight","sighted","sightless","sightly",
"sightscreen","sightsee","sightseer","sign","signal",
"signaler","signalise","signalize","signaller","signally",
"signalman","signatory","signature","signer","signet",
"significance","significant","signification","signify","signor",
"signora","signorina","signpost","signposted","silage",
"silence","silencer","silent","silhouette","silica",
"silicate","silicon","silicone","silicosis","silk",
"silken","silkworm","silky","sill","sillabub",
"silly","silo","silt","silvan","silver",
"silverfish","silverside","silversmith","silverware","silvery",
"simian","similar","similarity","similarly","simile",
"similitude","simmer","simony","simper","simple",
"simpleton","simplicity","simplify","simply","simulacrum",
"simulate","simulated","simulation","simulator","simultaneous",
"sin","since","sincere","sincerely","sincerity",
"sinecure","sinew","sinewy","sinful","sing",
"singe","singhalese","singing","single","singleness",
"singles","singlestick","singlet","singleton","singly",
"singsong","singular","singularly","sinhalese","sinister",
"sink","sinker","sinless","sinner","sinology",
"sinuous","sinus","sip","siphon","sir",
"sire","siren","sirloin","sirocco","sirrah",
"sis","sisal","sissy","sister","sisterhood",
"sisterly","sit","sitar","site","sitter",
"sitting","situated","situation","six","sixpence",
"sixteen","sixty","sizable","size","sizeable",
"sizzle","sizzler","skate","skateboard","skedaddle",
"skeet","skein","skeleton","skeptic","skeptical",
"skepticism","sketch","sketchpad","sketchy","skew",
"skewbald","skewer","ski","skibob","skid",
"skidlid","skidpan","skiff","skiffle","skilful",
"skill","skilled","skillet","skillful","skim",
"skimmer","skimp","skimpy","skin","skinflint",
"skinful","skinhead","skinny","skint","skip",
"skipper","skirl","skirmish","skirt","skit",
"skitter","skittish","skittle","skittles","skive",
"skivvy","skua","skulduggery","skulk","skull",
"skullcap","skullduggery","skunk","sky","skydiving",
"skyhook","skyjack","skylark","skylight","skyline",
"skyrocket","skyscraper","skywriting","slab","slack",
"slacken","slacker","slacks","slag","slagheap",
"slain","slake","slalom","slam","slander",
"slanderous","slang","slangy","slant","slantwise",
"slap","slapdash","slaphappy","slapstick","slash",
"slat","slate","slattern","slaty","slaughter",
"slaughterhouse","slave","slaver","slavery","slavic",
"slavish","slay","sleazy","sled","sledge",
"sledgehammer","sleek","sleep","sleeper","sleepless",
"sleepwalker","sleepy","sleepyhead","sleet","sleeve",
"sleigh","slender","slenderise","slenderize","slept",
"sleuth","slew","slewed","slice","slick",
"slicker","slide","slight","slightly","slim",
"slimy","sling","slingshot","slink","slip",
"slipcover","slipknot","slipover","slipper","slippery",
"slippy","slips","slipshod","slipstream","slipway",
"slit","slither","slithery","sliver","slivovitz",
"slob","slobber","sloe","slog","slogan",
"sloop","slop","slope","sloppy","slosh",
"sloshed","slot","sloth","slothful","slouch",
"slough","sloven","slovenly","slow","slowcoach",
"slowworm","sludge","slue","slug","sluggard",
"sluggish","sluice","sluiceway","slum","slumber",
"slumberous","slummy","slump","slung","slunk",
"slur","slurp","slurry","slush","slut",
"sly","smack","smacker","small","smallholder",
"smallholding","smallpox","smalls","smarmy","smart",
"smarten","smash","smashed","smasher","smashing",
"smattering","smear","smell","smelly","smelt",
"smile","smirch","smirk","smite","smith",
"smithereens","smithy","smitten","smock","smocking",
"smog","smoke","smoker","smokescreen","smokestack",
"smoking","smoky","smolder","smooch","smooth",
"smoothie","smoothy","smorgasbord","smote","smother",
"smoulder","smudge","smug","smuggle","smut",
"smutty","snack","snaffle","snag","snail",
"snake","snakebite","snaky","snap","snapdragon",
"snapper","snappish","snappy","snapshot","snare",
"snarl","snatch","snazzy","sneak","sneaker",
"sneaking","sneaky","sneer","sneeze","snick",
"snicker","snide","sniff","sniffle","sniffles",
"sniffy","snifter","snigger","snip","snippet",
"snips","snitch","snivel","snob","snobbery",
"snobbish","snog","snood","snook","snooker",
"snoop","snooper","snoot","snooty","snooze",
"snore","snorkel","snort","snorter","snot",
"snotty","snout","snow","snowball","snowberry",
"snowbound","snowdrift","snowdrop","snowfall","snowfield",
"snowflake","snowline","snowman","snowplough","snowplow",
"snowshoe","snowstorm","snowy","snr","snub",
"snuff","snuffer","snuffle","snug","snuggle",
"soak","soaked","soaking","soap","soapbox",
"soapstone","soapsuds","soapy","soar","sob",
"sober","sobriety","sobriquet","soccer","sociable",
"social","socialise","socialism","socialist","socialite",
"socialize","society","sociology","sock","socket",
"sod","soda","sodden","sodium","sodomite",
"sodomy","soever","sofa","soft","softball",
"soften","softhearted","softie","software","softwood",
"softy","soggy","soigne","soignee","soil",
"sojourn","sol","solace","solar","solarium",
"sold","solder","soldier","soldierly","soldiery",
"sole","solecism","solely","solemn","solemnise",
"solemnity","solemnize","solicit","solicitor","solicitous",
"solicitude","solid","solidarity","solidify","solidity",
"solidus","soliloquise","soliloquize","soliloquy","solipsism",
"solitaire","solitary","solitude","solo","soloist",
"solstice","soluble","solution","solve","solvency",
"solvent","somber","sombre","sombrero","some",
"somebody","someday","somehow","somersault","something",
"sometime","sometimes","someway","somewhat","somewhere",
"somnambulism","somnolent","son","sonar","sonata",
"song","songbird","songbook","songster","sonic",
"sonnet","sonny","sonority","sonorous","sonsy",
"soon","soot","soothe","soothsayer","sop",
"sophism","sophisticate","sophisticated","sophistication","sophistry",
"sophomore","soporific","sopping","soppy","soprano",
"sorbet","sorcerer","sorcery","sordid","sore",
"sorehead","sorely","sorghum","sorority","sorrel",
"sorrow","sorry","sort","sortie","sos",
"sot","sottish","sou","soubrette","soubriquet",
"sough","sought","soul","soulful","soulless",
"sound","soundings","soundproof","soundtrack","soup",
"sour","source","sourdough","sourpuss","sousaphone",
"souse","soused","south","southbound","southeast",
"southeaster","southeasterly","southeastern","southeastward","southeastwards",
"southerly","southern","southerner","southernmost","southpaw",
"southward","southwards","southwest","southwester","southwesterly",
"southwestern","southwestward","southwestwards","souvenir","sovereign",
"sovereignty","soviet","sow","sox","soy",
"soybean","sozzled","spa","space","spacecraft",
"spaceship","spacesuit","spacing","spacious","spade",
"spadework","spaghetti","spake","spam","span",
"spangle","spaniel","spank","spanking","spanner",
"spar","spare","spareribs","sparing","spark",
"sparkle","sparkler","sparks","sparrow","sparse",
"spartan","spasm","spasmodic","spastic","spat",
"spatchcock","spate","spatial","spatter","spatula",
"spavin","spawn","spay","speak","speakeasy",
"speaker","speakership","spear","spearhead","spearmint",
"spec","special","specialise","specialised","specialist",
"speciality","specialize","specialized","specially","specie",
"species","specific","specifically","specification","specifics",
"specify","specimen","specious","speck","speckle",
"spectacle","spectacled","spectacles","spectacular","spectator",
"specter","spectral","spectre","spectroscope","spectrum",
"speculate","speculation","speculative","speech","speechify",
"speechless","speed","speedboat","speeding","speedometer",
"speedway","speedwell","speedy","spelaeology","speleology",
"spell","spellbind","spelling","spend","spender",
"spendthrift","spent","sperm","spermaceti","spermatozoa",
"spew","sphagnum","sphere","spherical","spheroid",
"sphincter","sphinx","spice","spicy","spider",
"spidery","spiel","spigot","spike","spikenard",
"spiky","spill","spillover","spillway","spin",
"spinach","spinal","spindle","spindly","spine",
"spineless","spinet","spinnaker","spinner","spinney",
"spinster","spiny","spiral","spire","spirit",
"spirited","spiritless","spirits","spiritual","spiritualise",
"spiritualism","spirituality","spiritualize","spirituous","spirt",
"spit","spite","spitfire","spittle","spittoon",
"spiv","splash","splashy","splat","splatter",
"splay","splayfoot","spleen","splendid","splendiferous",
"splendor","splendour","splenetic","splice","splicer",
"splint","splinter","split","splits","splitting",
"splotch","splurge","splutter","spoil","spoilage",
"spoils","spoilsport","spoke","spoken","spokeshave",
"spokesman","spoliation","spondee","sponge","spongy",
"sponsor","spontaneous","spoof","spook","spooky",
"spool","spoon","spoonerism","spoonful","spoor",
"sporadic","spore","sporran","sport","sporting",
"sportive","sports","sportsman","sportsmanlike","sportsmanship",
"sporty","spot","spotless","spotlight","spotted",
"spotter","spotty","spouse","spout","sprain",
"sprang","sprat","sprawl","spray","sprayer",
"spread","spree","sprig","sprigged","sprightly",
"spring","springboard","springbok","springtime","springy",
"sprinkle","sprinkler","sprinkling","sprint","sprite",
"sprocket","sprout","spruce","sprung","spry",
"spud","spume","spun","spunk","spur",
"spurious","spurn","spurt","sputter","sputum",
"spy","spyglass","squab","squabble","squad",
"squadron","squalid","squall","squalor","squander",
"square","squash","squashy","squat","squatter",
"squaw","squawk","squeak","squeaky","squeal",
"squeamish","squeegee","squeeze","squeezer","squelch",
"squib","squid","squidgy","squiffy","squiggle",
"squint","squirarchy","squire","squirearchy","squirm",
"squirrel","squirt","squirter","sri","srn",
"ssh","stab","stabbing","stabilise","stabiliser",
"stability","stabilize","stabilizer","stable","stabling",
"staccato","stack","stadium","staff","stag",
"stage","stagecoach","stager","stagestruck","stagger",
"staggering","staggers","staging","stagnant","stagnate",
"stagy","staid","stain","stainless","stair",
"staircase","stairs","stairwell","stake","stakeholder",
"stakes","stalactite","stalagmite","stale","stalemate",
"stalk","stall","stallholder","stallion","stalls",
"stalwart","stamen","stamina","stammer","stamp",
"stampede","stance","stanch","stanchion","stand",
"standard","standardise","standardize","standby","standing",
"standoffish","standpipe","standpoint","standstill","stank",
"stanza","staple","stapler","star","starboard",
"starch","starchy","stardom","stardust","stare",
"starfish","stargazer","stargazing","staring","stark",
"starkers","starlet","starlight","starling","starlit",
"starry","stars","start","starter","starters",
"startle","starvation","starve","starveling","stash",
"state","statecraft","statehood","stateless","stately",
"statement","stateroom","states","stateside","statesman",
"static","statics","station","stationary","stationer",
"stationery","stationmaster","statistic","statistician","statistics",
"statuary","statue","statuesque","statuette","stature",
"status","statute","statutory","staunch","stave",
"staves","stay","stayer","stays","std",
"stead","steadfast","steady","steak","steal",
"stealth","stealthy","steam","steamboat","steamer",
"steamroller","steamship","steed","steel","steelworker",
"steelworks","steely","steelyard","steenbok","steep",
"steepen","steeple","steeplechase","steeplejack","steer",
"steerage","steerageway","steersman","stein","steinbok",
"stele","stellar","stem","stench","stencil",
"stenographer","stenography","stentorian","step","stepbrother",
"stepchild","stepladder","stepparent","steps","stepsister",
"stereo","stereoscope","stereoscopic","stereotype","sterile",
"sterilise","sterility","sterilize","sterling","stern",
"sternum","steroid","stertorous","stet","stethoscope",
"stetson","stevedore","stew","steward","stewardess",
"stewardship","stewed","stick","sticker","stickleback",
"stickler","stickpin","sticks","sticky","stiff",
"stiffen","stiffener","stiffening","stifle","stigma",
"stigmata","stigmatise","stigmatize","stile","stiletto",
"still","stillbirth","stillborn","stillroom","stilly",
"stilt","stilted","stilton","stimulant","stimulate",
"stimulus","sting","stinger","stingo","stingray",
"stingy","stink","stinking","stint","stipend",
"stipendiary","stipple","stipulate","stipulation","stir",
"stirrer","stirring","stirrup","stitch","stoat",
"stock","stockade","stockbreeder","stockbroker","stockcar",
"stockfish","stockholder","stockily","stockinet","stockinette",
"stocking","stockist","stockjobber","stockman","stockpile",
"stockpot","stockroom","stocks","stocktaking","stocky",
"stockyard","stodge","stodgy","stoic","stoical",
"stoicism","stoke","stokehold","stoker","stole",
"stolen","stolid","stomach","stomachache","stomachful",
"stomp","stone","stonebreaker","stonecutter","stoned",
"stoneless","stonemason","stonewall","stoneware","stonework",
"stony","stood","stooge","stool","stoolpigeon",
"stoop","stop","stopcock","stopgap","stopover",
"stoppage","stopper","stopping","stopwatch","storage",
"store","storehouse","storekeeper","storeroom","stores",
"storey","storied","stork","storm","stormbound",
"stormy","story","storybook","storyteller","stoup",
"stout","stouthearted","stove","stovepipe","stow",
"stowage","stowaway","straddle","stradivarius","strafe",
"straggle","straggly","straight","straightaway","straightedge",
"straighten","straightforward","straightway","strain","strained",
"strainer","strait","straitened","straitjacket","straitlaced",
"straits","strand","stranded","strange","stranger",
"strangle","stranglehold","strangulate","strangulation","strap",
"straphanging","strapless","strapping","strata","stratagem",
"strategic","strategist","strategy","stratification","stratify",
"stratosphere","stratum","straw","strawberry","strawboard",
"stray","streak","streaker","streaky","stream",
"streamer","streamline","streamlined","street","streetcar",
"streetwalker","strength","strengthen","strenuous","streptococcus",
"streptomycin","stress","stretch","stretcher","stretchy",
"strew","strewth","striated","striation","stricken",
"strict","stricture","stride","stridency","strident",
"stridulate","strife","strike","strikebound","strikebreaker",
"strikebreaking","striker","striking","string","stringency",
"stringent","strings","stringy","strip","stripe",
"striped","stripling","stripper","striptease","stripy",
"strive","strode","stroke","stroll","stroller",
"strolling","strong","strongarm","strongbox","stronghold",
"strontium","strop","strophe","stroppy","strove",
"struck","structural","structure","strudel","struggle",
"strum","strumpet","strung","strut","strychnine",
"stub","stubble","stubborn","stubby","stucco",
"stuck","stud","studbook","student","studied",
"studio","studious","study","stuff","stuffing",
"stuffy","stultify","stumble","stump","stumper",
"stumpy","stun","stung","stunk","stunner",
"stunning","stunt","stupefaction","stupefy","stupendous",
"stupid","stupidity","stupor","sturdy","sturgeon",
"stutter","sty","stye","stygian","style",
"stylise","stylish","stylist","stylistic","stylistics",
"stylize","stylus","stymie","styptic","suasion",
"suave","sub","subaltern","subatomic","subcommittee",
"subconscious","subcontinent","subcontract","subcontractor","subcutaneous",
"subdivide","subdue","subdued","subedit","subeditor",
"subheading","subhuman","subject","subjection","subjective",
"subjoin","subjugate","subjunctive","sublease","sublet",
"sublieutenant","sublimate","sublime","subliminal","submarine",
"submariner","submerge","submergence","submersible","submission",
"submissive","submit","subnormal","suborbital","subordinate",
"suborn","subplot","subpoena","subscribe","subscriber",
"subscription","subsequent","subservience","subservient","subside",
"subsidence","subsidiary","subsidise","subsidize","subsidy",
"subsist","subsistence","subsoil","subsonic","substance",
"substandard","substantial","substantially","substantiate","substantival",
"substantive","substation","substitute","substratum","substructure",
"subsume","subtenant","subtend","subterfuge","subterranean",
"subtitle","subtitles","subtle","subtlety","subtopia",
"subtract","subtraction","subtropical","suburb","suburban",
"suburbanite","suburbia","suburbs","subvention","subversive",
"subvert","subway","succeed","success","successful",
"succession","successive","successor","succinct","succor",
"succour","succubus","succulence","succulent","succumb",
"such","suchlike","suck","sucker","suckle",
"suckling","sucrose","suction","sudden","suds",
"sue","suet","suffer","sufferable","sufferance",
"sufferer","suffering","suffice","sufficiency","sufficient",
"suffix","suffocate","suffragan","suffrage","suffragette",
"suffuse","sugar","sugarcane","sugarcoated","sugarloaf",
"sugary","suggest","suggestible","suggestion","suggestive",
"suicidal","suicide","suit","suitability","suitable",
"suitcase","suiting","suitor","sulfate","sulfide",
"sulfur","sulfuret","sulfurous","sulk","sulks",
"sulky","sullen","sully","sulphate","sulphide",
"sulphur","sulphuret","sulphurous","sultan","sultana",
"sultanate","sultry","sum","sumac","sumach",
"summarise","summarize","summary","summat","summation",
"summer","summerhouse","summertime","summery","summit",
"summon","summons","sump","sumptuary","sumptuous",
"sun","sunbaked","sunbathe","sunbeam","sunblind",
"sunbonnet","sunburn","sunburnt","sundae","sunday",
"sundeck","sunder","sundew","sundial","sundown",
"sundowner","sundrenched","sundries","sundry","sunfish",
"sunflower","sung","sunglasses","sunk","sunken",
"sunlamp","sunless","sunlight","sunlit","sunny",
"sunray","sunrise","sunroof","sunset","sunshade",
"sunshine","sunspot","sunstroke","suntan","suntrap",
"sup","super","superabundance","superabundant","superannuate",
"superannuated","superannuation","superb","supercharged","supercharger",
"supercilious","superconductivity","superduper","superego","superficial",
"superficies","superfine","superfluity","superfluous","superhuman",
"superimpose","superintend","superintendent","superior","superlative",
"superlatively","superman","supermarket","supernal","supernatural",
"supernova","supernumerary","superscription","supersede","supersession",
"supersonic","superstar","superstition","superstitious","superstructure",
"supertax","supervene","supervise","supervisory","supine",
"supper","supplant","supple","supplement","supplementary",
"suppliant","supplicant","supplicate","supplier","supplies",
"supply","support","supportable","supporter","supportive",
"suppose","supposed","supposedly","supposing","supposition",
"suppository","suppress","suppression","suppressive","suppressor",
"suppurate","supranational","supremacist","supremacy","supreme",
"surcharge","surcoat","surd","sure","surefire",
"surefooted","surely","surety","surf","surface",
"surfboard","surfboat","surfeit","surfer","surge",
"surgeon","surgery","surgical","surly","surmise",
"surmount","surname","surpass","surpassing","surplice",
"surplus","surprise","surprising","surreal","surrealism",
"surrealist","surrealistic","surrender","surreptitious","surrey",
"surrogate","surround","surrounding","surroundings","surtax",
"surveillance","survey","surveyor","survival","survive",
"survivor","susceptibilities","susceptibility","susceptible","suspect",
"suspend","suspender","suspenders","suspense","suspension",
"suspicion","suspicious","sustain","sustenance","suttee",
"suture","suzerain","suzerainty","svelte","swab",
"swaddle","swag","swagger","swain","swallow",
"swallowtailed","swam","swami","swamp","swampy",
"swan","swank","swanky","swansdown","swansong",
"swap","sward","swarf","swarm","swarthy",
"swashbuckler","swashbuckling","swastika","swat","swatch",
"swath","swathe","swatter","sway","swayback",
"swear","swearword","sweat","sweatband","sweated",
"sweater","sweatshirt","sweatshop","sweaty","swede",
"sweep","sweeper","sweeping","sweepings","sweepstake",
"sweepstakes","sweet","sweetbread","sweetbriar","sweetbrier",
"sweeten","sweetener","sweetening","sweetheart","sweetie",
"sweetish","sweetmeat","sweets","swell","swelling",
"swelter","sweltering","swept","swerve","swift",
"swig","swill","swim","swimming","swimmingly",
"swindle","swine","swineherd","swing","swingeing",
"swinger","swinging","swinish","swipe","swirl",
"swish","switch","switchback","switchblade","switchboard",
"switchgear","switchman","swivel","swiz","swizzle",
"swollen","swoon","swoop","swop","sword",
"swordfish","swordplay","swordsman","swordsmanship","swordstick",
"swore","sworn","swot","swum","swung",
"sybarite","sybaritic","sycamore","sycophant","sycophantic",
"sylabub","syllabary","syllabic","syllabify","syllable",
"syllabub","syllabus","syllogism","syllogistic","sylph",
"sylphlike","sylvan","symbiosis","symbol","symbolic",
"symbolise","symbolism","symbolist","symbolize","symmetrical",
"symmetry","sympathetic","sympathies","sympathise","sympathize",
"sympathy","symphonic","symphony","symposium","symptom",
"symptomatic","synagogue","sync","synch","synchonise",
"synchromesh","synchronize","synchrotron","syncopate","syncope",
"syndic","syndicalism","syndicate","syndrome","synod",
"synonym","synonymous","synopsis","synoptic","syntactic",
"syntax","synthesis","synthesise","synthesiser","synthesize",
"synthesizer","synthetic","syphilis","syphilitic","syphon",
"syringe","syrup","syrupy","system","systematic",
"systematise","systematize","systemic","tab","tabard",
"tabasco","tabby","tabernacle","table","tableau",
"tablecloth","tableland","tablemat","tablespoon","tablespoonful",
"tablet","tableware","tabloid","taboo","tabor",
"tabular","tabulate","tabulator","tacit","taciturn",
"tack","tackiness","tackle","tacky","tact",
"tactic","tactical","tactician","tactics","tactile",
"tactual","tadpole","taffeta","taffrail","taffy",
"tag","tail","tailback","tailboard","tailcoat",
"taillight","tailor","tailpiece","tails","tailspin",
"tailwind","taint","take","takeaway","takeoff",
"takeover","taking","takings","talc","tale",
"talebearer","talent","talented","talisman","talk",
"talkative","talker","talkie","talks","tall",
"tallboy","tallow","tally","tallyho","tallyman",
"talmud","talon","tamale","tamarind","tamarisk",
"tambour","tambourine","tame","tammany","tamp",
"tamper","tampon","tan","tandem","tang",
"tangent","tangential","tangerine","tangible","tangle",
"tango","tank","tankard","tanker","tanner",
"tannery","tannin","tanning","tannoy","tansy",
"tantalise","tantalize","tantalus","tantamount","tantrum",
"taoism","tap","tape","taper","tapestry",
"tapeworm","tapioca","tapir","tappet","taproom",
"taproot","taps","tar","tarantella","tarantula",
"tarboosh","tardy","target","tariff","tarmac",
"tarn","tarnish","taro","tarot","tarpaulin",
"tarragon","tarry","tarsal","tarsus","tart",
"tartan","tartar","task","taskmaster","tassel",
"taste","tasteful","tasteless","taster","tasty",
"tat","tatas","tatter","tattered","tatters",
"tatting","tattle","tattoo","tattooist","tatty",
"taught","taunt","taurus","taut","tautological",
"tautology","tavern","tawdry","tawny","tawse",
"tax","taxation","taxi","taxidermist","taxidermy",
"taximeter","taxonomy","tea","teabag","teacake",
"teach","teacher","teaching","teacup","teacupful",
"teagarden","teahouse","teak","teakettle","teal",
"tealeaf","team","teamster","teamwork","teapot",
"tear","tearaway","teardrop","tearful","teargas",
"tearjerker","tearless","tearoom","tease","teasel",
"teaser","teaspoon","teaspoonful","teat","teatime",
"teazle","tech","technical","technicality","technician",
"technique","technocracy","technocrat","technological","technologist",
"technology","techy","tedious","tedium","tee",
"teem","teeming","teenage","teenager","teens",
"teenybopper","teeter","teeth","teethe","teetotal",
"teetotaler","teetotaller","teflon","tegument","tele",
"telecast","telecommunications","telegram","telegraph","telegrapher",
"telegraphese","telegraphic","telemarketing","telemeter","telemetry",
"teleology","telepathic","telepathist","telepathy","telephone",
"telephonist","telephony","telephotograph","telephotography","teleprinter",
"teleprompter","telescope","telescopic","televise","television",
"televisual","telex","telfer","tell","teller",
"telling","telltale","telly","telpher","telstar",
"temerity","temp","temper","tempera","temperament",
"temperamental","temperance","temperate","temperature","tempest",
"tempestuous","template","temple","templet","tempo",
"temporal","temporary","temporise","temporize","tempt",
"temptation","ten","tenable","tenacious","tenacity",
"tenancy","tenant","tenantry","tench","tend",
"tendency","tendentious","tender","tenderfoot","tenderhearted",
"tenderise","tenderize","tenderloin","tendon","tendril",
"tenement","tenet","tenner","tennis","tenon",
};
}
