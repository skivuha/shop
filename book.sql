-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 07 2015 г., 12:11
-- Версия сервера: 5.5.41-log
-- Версия PHP: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `book`
--

-- --------------------------------------------------------

--
-- Структура таблицы `shop_authors`
--

CREATE TABLE IF NOT EXISTS `shop_authors` (
  `authors_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `authors_name` text NOT NULL,
  PRIMARY KEY (`authors_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Дамп данных таблицы `shop_authors`
--

INSERT INTO `shop_authors` (`authors_id`, `authors_name`) VALUES
(1, 'Tyler Knott Gregson'),
(2, 'Pleasefindthis'),
(3, 'Robert M. Drake'),
(5, 'Igor Lalala'),
(6, 'Tyler Knott'),
(8, 'Scott O''dell'),
(9, 'Scot Richards'),
(10, 'Chinua Achebe'),
(11, 'Peter Ackroyd'),
(12, 'Douglas Adams'),
(13, 'Aaron Akinyemi'),
(14, 'Alexandra Harris'),
(15, 'Margaret Atwood'),
(16, 'Jane Austen'),
(17, 'Paul Auster'),
(18, 'John Banville'),
(19, 'Nicola Barker'),
(20, 'Donald Barthelme'),
(21, 'Saul Bellow'),
(22, 'John Betjeman');

-- --------------------------------------------------------

--
-- Структура таблицы `shop_books`
--

CREATE TABLE IF NOT EXISTS `shop_books` (
  `book_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `price` float unsigned NOT NULL,
  `book_name` text CHARACTER SET latin1 NOT NULL,
  `img` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'no_image.png',
  `content` text CHARACTER SET latin1 NOT NULL,
  `visible` enum('0','1') CHARACTER SET latin1 NOT NULL DEFAULT '1',
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=72 ;

--
-- Дамп данных таблицы `shop_books`
--

INSERT INTO `shop_books` (`book_id`, `price`, `book_name`, `img`, `content`, `visible`) VALUES
(1, 20, 'Island of the Blue Dolphins', 'bookDetails.jpg', '<p>Product Description. The Newberry Medal-winning story of a 12-year old girl who lives alone on a Pacific island after she leaps from a rescue ship. Isolated on the island for eighteen years, Karana forages for food, builds weapons to fight predators, clothes herself in a cormorant feathered skirt, and finds strength and peace in her seclusion. A classic tale of discovery and solitude returns to Houghton Mifflin Harcourt for its 50th anniversary, with a new introduction by Lois Lowry.Dear Amazon readers,Last summer, when I was asked to write an introduction to a new edition of Island of the Blue Dolphins, my mind went back in time to the 1960s, when my children were young and it was one of their best-loved books.</p><br>\n                <p>But a later memory surfaced, as well, of a party I was invited to in the summer of 1979. By now the kids were grown. I was in New York to attend a convention of the American Library Association, and Scott O''Dell''s publisher, Houghton Mifflin, was honoring him at a reception being held at the St. Regis Hotel. I had never met Mr. O''Dell. But because of my own children I knew his books, and I was pleased to be invited to such an illustrious event.</p><br>\n                <p>I was staying at a nearby hotel and planned to walk over to the party. But when I began to get dressed, I encountered a problem. I was wearing, I remember, a rose-colored crpe de Chine dress. It buttoned up the back. I was alone in my hotel room. I buttoned the bottom buttons, and I buttoned the top buttons, but there was one button in the middle of my back that I simply could not reach. It makes me laugh today, thinking about it, picturing the contortions I went through in that hotel room: twisting my arms, twisting my back, all to no avail. The clock was ticking. The party would start soon. I had no other clothes except the casual things I''d been wearing all day and which were now wrinkled from the summer heat.</p><br>\n                <p>Finally I decided, The heck with it. I left the room with the button unbuttoned and headed off. When I got in my hotel elevator, a benign-looking older couple, probably tourists from the Midwest, were already standing inside, and I explained my predicament politely and asked if they could give me a hand. The gray-haired man kindly buttoned my dress for me. We parted company in the lobby of my hotel and off I went to the St. Regis, where I milled around and chatted with countless people, sipped wine, and waited for the guest of honor, Scott O''Dell, to be introduced. When he was, of course he turned out to be the eighty-one-year-old man who had buttoned my dress.</p><br>', '1'),
(2, 11.84, 'Chasers of the Light', 'book2.jpg', '<p>The epic made simple. The miracle in the mundane.</p>\r\n\r\n<p>One day, while browsing an antique store in Helena, Montana, photographer Tyler Knott Gregson stumbled upon a vintage Remington typewriter for sale. Standing up and using a page from a broken book he was buying for $2, he typed a poem without thinking, without planning, and without the ability to revise anything.</p>\r\n\r\n<p>He fell in love.</p>\r\n\r\n<p>Three years and almost one thousand poems later, Tyler is now known as the creator of the Typewriter Series: a striking collection of poems typed onto found scraps of paper or created via blackout method. Chasers of the Light features some of his most insightful and beautifully worded pieces of work-poems that illuminate grand gestures and small glimpses, poems that celebrate the beauty of a life spent chasing the light.</p>', '1'),
(3, 14.04, 'Love & Misadventure', 'book3.jpg', '<p>The enchanting work of Sydney author Lang Leav swings between the whimsical and woeful, expressing a complexity beneath its childlike facade. Her imagination stretches across a variety of disciplines encompassing art, poetry, and books.</p>\r\n\r\n<p>?Frequently invited to exhibit at high profile exhibitions in Australia, the U.S., and other countries, she has built a loyal following of international fans. Her handcrafted book, Charlie''s Widow, was presented to iconic film director Tim Burton at the opening of his Wonderland exhibition at the Australian Centre for the Moving Image.</p>\r\n\r\n<p>?Lang is a recipient of The Qantas Spirit of Youth Award and was granted a prestigious Churchill Fellowship.</p>\r\n\r\n<p>?She has completed shows in several cities, including Santa Monica for the renowned Copro Gallery, who have worked with artists such as Mark Ryden and Audrey Kawasaki. She was handpicked to exhibit in the landmark "Playboy Redux", curated by The Warhol Museum and Playboy Enterprises, alongside contemporary greats such as Gary Baseman and Tara McPherson.</p>', '1'),
(4, 19, 'I Wrote This for You', 'book4.jpg', '<p>I need you to understand something. I wrote this for you. I wrote this for you and only you. Everyone else who reads it, doesn''t get it." Started 2007, I Wrote This For You is an acclaimed exploration of hauntingly beautiful words, photography and emotion that''s unique to each person that reads it. This book gathers together nearly 200 of the most beautiful entries into four distinct chapters; Sun, Moon, Stars, Rain. Together with several new and exclusive entries that don''t appear anywhere else, each chapter of I Wrote This For You focuses on a different facet of life, love, loss, beginnings and endings.</p>', '1'),
(5, 12.52, 'Science: The stars', 'book5.jpg', '<p>This book employs the comparative method to understand societal collapses to which environmental problems contribute to the common youth and society as a whole. We all are broken and broken is its own kind of beautiful.</p>', '1'),
(6, 15, 'I Wrote This for You', 'book6.jpg', '<p>The follow-up to the #1 bestseller, I Wrote This For You: Just The Words presents twice the number of entries with over 400 works from the internationally acclaimed poetry and photography project; including several new and never before seen poems. While focussing on the words from the project, new photography launches each section which portray everyone''s journey through the world: Love Found, Being In Love, Love Lost, Hope, Despair, Living and Dying.</p>', '1'),
(7, 35, 'The Bone Clocks', 'book7.jpg', '<p>Following a terrible fight with her mother over her boyfriend, fifteen-year-old Holly Sykes slams the door on her family and her old life. But Holly is no typical teenage runaway: A sensitive child once contacted by voices she knew only as "the radio people," Holly is a lightning rod for psychic phenomena. Now, as she wanders deeper into the English countryside, visions and coincidences reorder her reality until they assume the aura of a nightmare brought to life.</p>\r\n<p>For Holly has caught the attention of a cabal of dangerous mystics-and their enemies. But her lost weekend is merely the prelude to a shocking disappearance that leaves her family irrevocably scarred. This unsolved mystery will echo through every decade of Holly''s life, affecting all the people Holly loves-even the ones who are not yet born.</p>\r\n<p>A Cambridge scholarship boy grooming himself for wealth and influence, a conflicted father who feels alive only while reporting on the war in Iraq, a middle-aged writer mourning his exile from the bestseller list-all have a part to play in this surreal, invisible war on the margins of our world. From the medieval Swiss Alps to the nineteenth-century Australian bush, from a hotel in Shanghai to a Manhattan townhouse in the near future, their stories come together in moments of everyday grace and extraordinary wonder.</p>', '1'),
(8, 24.18, 'A Deadly Wandering', 'book8.jpg', '<p>From Pulitzer Prize-winning journalist Matt Richtel, a brilliant, narrative-driven exploration of technology''s vast influence on the human mind and society, dramatically-told through the lens of a tragic "texting-while-driving" car crash that claimed the lives of two rocket scientists in 2006.</p>\r\n<p>In this ambitious, compelling, and beautifully written book, Matt Richtel, a Pulitzer Prize-winning reporter for the New York Times, examines the impact of technology on our lives through the story of Utah college student Reggie Shaw, who killed two scientists while texting and driving. Richtel follows Reggie through the tragedy, the police investigation, his prosecution, and ultimately, his redemption.</p>\r\n<p>In the wake of his experience, Reggie has become a leading advocate against "distracted driving." Richtel interweaves Reggie''s story with cutting-edge scientific findings regarding human attention and the impact of technology on our brains, proposing solid, practical, and actionable solutions to help manage this crisis individually and as a society.</p>\r\n<p>A propulsive read filled with fascinating, accessible detail, riveting narrative tension, and emotional depth, A Deadly Wandering explores one of the biggest questions of our time-what is all of our technology doing to us?-and provides unsettling and important answers and information we all need.</p>', '1'),
(9, 20, 'Cosby: His Life and Times', 'book9.jpg', '<p>The first major biography of an American icon, comedian Bill Cosby. Based on extensive research and in-depth interviews with Cosby and more than sixty of his closest friends and associates, it is a frank, fun and fascinating account of his life and historic legacy.</p>\r\n<p>Far from the gentle worlds of his routines or TV shows, Cosby grew up in a Philadelphia housing project, the son of an alcoholic, largely absent father and a loving but overworked mother. With novelistic detail, award winning journalist Mark Whitaker tells the story of how, after dropping out of high school, Cosby turned his life around by joining the Navy, talking his way into college, and seizing his first breaks as a stand-up comedian.</p>\r\n<p>Published on the 30th anniversary of The Cosby Show, the book reveals the behind-the-scenes story of that groundbreaking sitcom as well as Cosby''s bestselling albums, breakout role on I Spy, and pioneering place in children''s TV. But it also deals with professional setbacks and personal dramas, from an affair that sparked public scandal to the murder of his only son, and the private influence of his wife of fifty years, Camille Cosby.</p>\r\n<p>Whitaker explores the roots of Cosby''s controversial stands on race, as well as "the Cosby effect" that helped pave the way for a black president. For any fan of Bill Cosby''s work, and any student of American television, comedy, or social history, Cosby: His Life and Times is an essential read.</p>', '1'),
(10, 20, 'The Secret Place', 'book10.jpg', '<p>The photo on the card shows a boy who was found murdered, a year ago, on the grounds of a girls'' boarding school in the leafy suburbs of Dublin. The caption says I KNOW WHO KILLED HIM.</p>\r\n<p>Detective Stephen Moran has been waiting for his chance to get a foot in the door of Dublin''s Murder Squad-and one morning, sixteen-year-old Holly Mackey brings him this photo. "The Secret Place," a board where the girls at St. Kilda''s School can pin up their secrets anonymously, is normally a mishmash of gossip and covert cruelty, but today someone has used it to reignite the stalled investigation into the murder of handsome, popular Chris Harper. Stephen joins forces with the abrasive Detective Antoinette Conway to find out who and why.</p>\r\n<p>But everything they discover leads them back to Holly''s close-knit group of friends and their fierce enemies, a rival clique-and to the tangled web of relationships\r\nthat bound all the girls to Chris Harper. Every step in their direction turns up the pressure. Antoinette Conway is already suspicious of Stephen''s links to the Mackey family. St. Kilda''s will go a long way to keep murder outside their walls. Holly''s father, Detective Frank Mackey, is circling, ready to pounce if any of the new evidence points toward his daughter. And the private underworld of teenage girls can be more mysterious and more dangerous than either of the detectives imagined.</p>', '1'),
(11, 19, 'What If?', 'book11.jpg', '<p><strong>From the creator of the wildly popular webcomic xkcd, hilarious and informative answers to important questions you probably never thought to ask.</strong></p>\r\n<p>Millions of people visit xkcd.com each week to read Randall Munroe''s iconic webcomic. His stick-figure drawings about science, technology, language, and love have a large and passionate following.</p>\r\n<p>Fans of xkcd ask Munroe a lot of strange questions. What if you tried to hit a baseball pitched at 90 percent the speed of light? How fast can you hit a speed bump while driving and live? If there was a robot apocalypse, how long would humanity last?</p>\r\n<p>In pursuit of answers, Munroe runs computer simulations, pores over stacks of declassified military research memos, solves differential equations, and consults with nuclear reactor operators. His responses are masterpieces of clarity and hilarity, complemented by signature xkcd comics. They often predict the complete annihilation of humankind, or at least a really big explosion.</p>\r\n<p>The book features new and never-before-answered questions, along with updated and expanded versions of the most popular answers from the xkcd website. What If? will be required reading for xkcd fans and anyone who loves to ponder the hypothetical.</p>', '1'),
(12, 20, 'I''ll Drink to That', 'book12.jpg', '<p>Eighty-six-year-old Betty Halbreich is a true original. A tough broad who could have stepped straight out of Stephen Sondheim''s repertoire, she has spent nearly forty years as the legendary personal shopper at Bergdorf Goodman, where she works with socialites, stars, and ordinary women off the street. She has helped many find their true selves through clothes, frank advice, and her own brand of wisdom. She is trusted by the most discriminating persons-including Hollywood''s top stylists-to tell them what looks best. But Halbreich''s personal transformation from a cosseted young girl to a fearless truth teller is the greatest makeover of her career.</p>\r\n<p>A Chicago native, Halbreich moved to Manhattan at twenty after marrying the dashing Sonny Halbreich, a true character right out of Damon Runyon who liked the nightlife of New York in the fifties. On the surface, they were a great match, but looks can be deceiving; an unfaithful Sonny was emotionally distant while Halbreich became increasingly anguished. After two decades, the fraying marriage finally came undone. Bereft without Sonny and her identity as his wife, she hit rock bottom.</p>\r\n<p>After she began the frightening process of reclaiming herself and started therapy, Halbreich was offered a lifeline in the form of a job at the legendary luxury store Bergdorf Goodman. Soon, she was asked to run the store''s first personal shopping service. It was a perfect fit.</p>\r\n<p>Meticulous, impeccable, hardworking, elegant, and-most of all-delightfully funny, Halbreich has never been afraid to tell it to her clients straight. She won''t sell something just to sell it. If an outfit or shoe or purse is too expensive, she''ll dissuade you from buying it. As Halbreich says, "There are two things nobody wants to face: their closet and their mirror." She helps women do both, every day.</p>', '1'),
(13, 14.97, 'Station Eleven: A novel', 'book13.jpg', '<p>An audacious, darkly glittering novel set in the eerie days of civilization''s collapse, Station Eleven tells the spellbinding story of a Hollywood star, his would-be savior, and a nomadic group of actors roaming the scattered outposts of the Great Lakes region, risking everything for art and humanity.</p>\r\n<p>One snowy night Arthur Leander, a famous actor, has a heart attack onstage during a production of King Lear. Jeevan Chaudhary, a paparazzo-turned-EMT, is in the audience and leaps to his aid. A child actress named Kirsten Raymonde watches in horror as Jeevan performs CPR, pumping Arthur''s chest as the curtain drops, but Arthur is dead. That same night, as Jeevan walks home from the theater, a terrible flu begins to spread. Hospitals are flooded and Jeevan and his brother barricade themselves inside an apartment, watching out the window as cars clog the highways, gunshots ring out, and life disintegrates around them.</p>\r\n<p>Fifteen years later, Kirsten is an actress with the Traveling Symphony. Together, this small troupe moves between the settlements of an altered world, performing Shakespeare and music for scattered communities of survivors. Written on their caravan, and tattooed on Kirsten’s arm is a line from Star Trek: "Because survival is insufficient." But when they arrive in St. Deborah by the Water, they encounter a violent prophet who digs graves for anyone who dares to leave.</p>\r\n<p>Spanning decades, moving back and forth in time, and vividly depicting life before and after the pandemic, this suspenseful, elegiac novel is rife with beauty. As Arthur falls in and out of love, as Jeevan watches the newscasters say their final good-byes, and as Kirsten finds herself caught in the crosshairs of the prophet, we see the strange twists of fate that connect them all. A novel of art, memory, and ambition, Station Eleven tells a story about the relationships that sustain us, the ephemeral nature of fame, and the beauty of the world as we know it.</p>', '1'),
(14, 17.5, 'The Short and Tragic Life of Robert Peace', 'book14.jpg', '<p>A heartfelt, and riveting biography of the short life of a talented young African-American man who escapes the slums of Newark for Yale University only to succumb to the dangers of the streets-and of one''s own nature-when he returns home.</p>\r\n<p>When author Jeff Hobbs arrived at Yale University, he became fast friends with the man who would be his college roommate for four years, Robert Peace. Robert''s life was rough from the beginning in the crime-ridden streets of Newark in the 1980s, with his father in jail and his mother earning less than $15,000 a year. But Robert was a brilliant student, and it was supposed to get easier when he was accepted to Yale, where he studied molecular biochemistry and biophysics. But it didn''t get easier. Robert carried with him the difficult dual nature of his existence, "fronting" in Yale, and at home.</p>\r\n<p>Through an honest rendering of Robert''s relationships-with his struggling mother, with his incarcerated father, with his teachers and friends and fellow drug dealers-The-Short and Tragic Life of Robert Peace encompasses the most enduring conflicts in America: race, class, drugs, community, imprisonment, education, family, friendship, and love. It''s about the collision of two fiercely insular worlds-the ivy-covered campus of Yale University and Newark, New Jersey, and the difficulty of going from one to the other and then back again. It''s about poverty, the challenges of single motherhood, and the struggle to find male role models in a community where a man is more likely to go to prison than to college. It''s about reaching one''s greatest potential and taking responsibility for your family no matter the cost. It''s about trying to live a decent life in America. But most all the story is about the tragic life of one singular brilliant young man. His end, a violent one, is heartbreaking and powerful and unforgettable.</p>', '1'),
(15, 20, 'Stone Mattress: Nine Tales', 'book15.jpg', '<p>A collection of highly imaginative short pieces that speak to our times with deadly accuracy. Vintage Atwood creativity, intelligence, and humor: think Alias Grace.</p>\r\n<p>Margaret Atwood turns to short fiction for the first time since her 2006 collection, Moral Disorder, with nine tales of acute psychological insight and turbulent relationships bringing to mind her award-winning 1996 novel, Alias Grace. A recently widowed fantasy writer is guided through a stormy winter evening by the voice of her late husband in "Alphinland," the first of three loosely linked stories about the romantic geometries of a group of writers and artists. In "The Freeze-Dried Bridegroom," a man who bids on an auctioned storage space has a surprise. In "Lusus Naturae," a woman born with a genetic abnormality is mistaken for a vampire. In "Torching the Dusties," an elderly lady with Charles Bonnet syndrome comes to terms with the little people she keeps seeing, while a newly formed populist group gathers to burn down her retirement residence. And in "Stone Mattress," a long-ago crime is avenged in the Arctic via a 1.9 billion-year-old stromatolite. In these nine tales, Margaret Atwood is at the top of her darkly humorous and seriously playful game.</p>', '1'),
(16, 17.5, 'The Paying Guests', 'book16.jpg', '<p><strong>From the bestselling author of The Little Stranger and Fingersmith, an enthralling novel about a widow and her daughter who take a young couple into their home in 1920s London.</strong></p>\r\n<p>It is 1922, and London is tense. Ex-servicemen are disillusioned; the out-of-work and the hungry are demanding change. And in South London, in a genteel Camberwell villa-a large, silent house now bereft of brothers, husband, and even servants-life is about to be transformed as impoverished widow Mrs. Wray and her spinster daughter, Frances, are obliged to take in lodgers.</p>\r\n\r\n<p>With the arrival of Lilian and Leonard Barber, a modern young couple of the "clerk class," the routines of the house will be shaken up in unexpected ways. Little do the Wrays know just how profoundly their new tenants will alter the course of Frances''s life-or, as passions mount and frustration gathers, how far-reaching, and how devastating, the disturbances will be.</p>\r\n\r\n<p>Short-listed for the Man Booker Prize three times, Sarah Waters has earned a reputation as one of our greatest writers of historical fiction, and here she has delivered again. A love story, a tension-filled crime story, and a beautifully atmospheric portrait of a fascinating time and place, The Paying Guests is Sarah Waters''s finest achievement yet.</p>', '1'),
(17, 20, 'Fives and Twenty-Fives', 'book17.jpg', '<p>It''s the rule-always watch your fives and twenty-fives. When a convoy halts to investigate a possible roadside bomb, stay in the vehicle and scan five meters in every direction. A bomb inside five meters cuts through the armor, killing everyone in the truck. Once clear, get out and sweep twenty-five meters. A bomb inside twenty-five meters kills the dismounted scouts investigating the road ahead.</p> \r\n\r\n<p>Fives and twenty-fives mark the measure of a marine''s life in the road repair platoon. Dispatched to fill potholes on the highways of Iraq, the platoon works to assure safe passage for citizens and military personnel. Their mission lacks the glory of the infantry, but in a war where every pothole contains a hidden bomb, road repair brings its own danger.</p>\r\n\r\n<p>Lieutenant Donavan leads the platoon, painfully aware of his shortcomings and isolated by his rank. Doc Pleasant, the medic, joined for opportunity, but finds his pride undone as he watches friends die. And there''s Kateb, known to the Americans as Dodge, an Iraqi interpreter whose love of American culture-from hip-hop to the dog-eared copy of Huck Finn he carries-is matched only by his disdain for what Americans are doing to his country.</p>\r\n\r\n<p>Returning home, they exchange one set of decisions and repercussions for another, struggling to find a place in a world that no longer knows them. A debut both transcendent and rooted in the flesh, Fives and Twenty-Fives is a deeply necessary novel.</p>', '1'),
(18, 20, 'The Witch with No Name', 'book18.jpg', '<p>It''s Rachel Morgan''s ultimate adventure . . . and anything can happen in this final book in the New York Times bestselling Hollows series.</p>\r\n\r\n<p>Rachel Morgan has come a long way from her early days as an inexperienced bounty hunter. She''s faced vampires and werewolves, banshees, witches, and soul-eating demons. She''s crossed worlds, channeled gods, and accepted her place as a day-walking demon. She''s lost friends and lovers and family, and an old enemy has unexpectedly become something much more.</p>\r\n\r\n<p>But power demands responsibility, and world-changers must always pay a price. Rachel has known that this day would come-and now it is here.</p>\r\n\r\n<p>To save Ivy''s soul and the rest of the living vampires, to keep the demonic ever after and our own world from destruction, Rachel Morgan will risk everything. . . .</p>', '1'),
(19, 20, 'The Broken Eye', 'book19.jpg', '<p><strong>New York Times bestseller</strong></p>\r\n\r\n<p>The Broken Eye continues the spectacular Lightbringer series from the New York Times bestselling author of The Black Prism and The Blinding Knife.</p>\r\n\r\n<p>As the old gods awaken and satrapies splinter, the Chromeria races to find the only man who can still end a civil war before it engulfs the known world. But Gavin Guile has been captured by an old enemy and enslaved on a pirate galley. Worse still, Gavin has lost more than his powers as Prism--he can''t use magic at all.</p>\r\n\r\n<p>Without the protection of his father, Kip Guile will face a master of shadows as his grandfather moves to choose a new Prism and put himself in power. With Teia and Karris, Kip will have to use all his wits to survive a secret war between noble houses, religious factions, rebels, and an ascendant order of hidden assassins called The Broken Eye.</p>', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `shop_book_a`
--

CREATE TABLE IF NOT EXISTS `shop_book_a` (
  `a_id` int(11) NOT NULL,
  `b_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `shop_book_a`
--

INSERT INTO `shop_book_a` (`a_id`, `b_id`) VALUES
(8, 1),
(8, 2),
(2, 5),
(9, 4),
(3, 1),
(1, 3),
(2, 6),
(3, 7),
(22, 8),
(5, 9),
(6, 10),
(21, 11),
(8, 12),
(9, 13),
(10, 14),
(11, 15),
(12, 16),
(13, 17),
(14, 18),
(15, 19),
(16, 20),
(17, 23),
(18, 24),
(0, 45),
(0, 48),
(0, 49),
(0, 50),
(0, 51),
(0, 52),
(0, 53),
(0, 62),
(0, 64),
(0, 65),
(0, 66),
(0, 69),
(3, 70),
(5, 71);

-- --------------------------------------------------------

--
-- Структура таблицы `shop_book_g`
--

CREATE TABLE IF NOT EXISTS `shop_book_g` (
  `g_id` int(11) NOT NULL,
  `b_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `shop_book_g`
--

INSERT INTO `shop_book_g` (`g_id`, `b_id`) VALUES
(7, 2),
(6, 1),
(5, 3),
(4, 1),
(3, 1),
(2, 3),
(1, 2),
(7, 1),
(3, 4),
(2, 5),
(7, 6),
(6, 7),
(2, 8),
(4, 9),
(2, 10),
(1, 11),
(4, 12),
(6, 13),
(7, 14),
(2, 15),
(5, 16),
(2, 17),
(1, 18),
(4, 19),
(3, 20),
(1, 23),
(1, 8),
(4, 11),
(1, 24),
(0, 45),
(0, 48),
(0, 49),
(0, 50),
(0, 51),
(0, 52),
(0, 53),
(0, 62),
(0, 64),
(0, 65),
(0, 66),
(0, 69),
(0, 70),
(4, 71);

-- --------------------------------------------------------

--
-- Структура таблицы `shop_book_order`
--

CREATE TABLE IF NOT EXISTS `shop_book_order` (
  `id_book` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `shop_book_order`
--

INSERT INTO `shop_book_order` (`id_book`, `id_order`, `quantity`) VALUES
(1, 8, 2),
(2, 8, 1),
(3, 8, 1),
(1, 9, 2),
(2, 9, 1),
(3, 9, 1),
(1, 10, 2),
(2, 10, 1),
(3, 10, 1),
(1, 11, 1),
(1, 13, 1),
(2, 13, 1),
(2, 15, 1),
(2, 16, 1),
(1, 16, 1),
(5, 17, 1),
(3, 17, 1),
(6, 17, 1),
(2, 17, 1),
(2, 18, 5),
(2, 19, 4),
(1, 19, 1),
(3, 19, 5),
(3, 20, 7),
(2, 20, 4),
(1, 20, 1),
(1, 21, 5),
(2, 21, 2),
(2, 22, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `shop_cart`
--

CREATE TABLE IF NOT EXISTS `shop_cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=79 ;

--
-- Дамп данных таблицы `shop_cart`
--

INSERT INTO `shop_cart` (`cart_id`, `book_id`, `quantity`, `user_id`, `status`) VALUES
(3, 2, 1, 14, '0'),
(11, 1, 1, 0, '0'),
(12, 1, 1, 0, '0'),
(33, 1, 5, 15, '1'),
(35, 3, 5, 0, '0'),
(36, 2, 5, 0, '0'),
(37, 2, 2, 15, '1'),
(38, 3, 5, 15, '1'),
(39, 1, 5, 15, '1'),
(40, 1, 5, 15, '1'),
(41, 2, 2, 15, '1'),
(42, 2, 2, 15, '1'),
(43, 2, 2, 15, '1'),
(44, 1, 5, 15, '1'),
(45, 5, 1, 15, '1'),
(46, 3, 5, 15, '1'),
(47, 6, 1, 15, '1'),
(48, 2, 2, 15, '1'),
(49, 2, 2, 15, '1'),
(63, 2, 2, 15, '1'),
(64, 1, 5, 15, '1'),
(65, 3, 5, 15, '1'),
(66, 3, 5, 15, '1'),
(67, 2, 2, 15, '1'),
(68, 1, 5, 15, '1'),
(74, 1, 5, 15, '1'),
(75, 2, 2, 15, '1'),
(78, 2, 1, 15, '1');

-- --------------------------------------------------------

--
-- Структура таблицы `shop_genre`
--

CREATE TABLE IF NOT EXISTS `shop_genre` (
  `genre_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `genre_name` text NOT NULL,
  PRIMARY KEY (`genre_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `shop_genre`
--

INSERT INTO `shop_genre` (`genre_id`, `genre_name`) VALUES
(1, 'Drama'),
(2, 'Fantastic'),
(3, 'Actions'),
(4, 'Melodrama'),
(5, 'Comedy'),
(6, 'Detectiv'),
(7, 'Adventure');

-- --------------------------------------------------------

--
-- Структура таблицы `shop_orders`
--

CREATE TABLE IF NOT EXISTS `shop_orders` (
  `id_order` int(11) NOT NULL AUTO_INCREMENT,
  `data_st` date NOT NULL,
  `id_user` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `id_payment` int(11) NOT NULL,
  `id_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_order`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Дамп данных таблицы `shop_orders`
--

INSERT INTO `shop_orders` (`id_order`, `data_st`, `id_user`, `total_price`, `id_payment`, `id_status`) VALUES
(16, '2015-04-05', 15, 22, 2, 1),
(17, '2015-04-05', 15, 37, 3, 1),
(18, '2015-04-05', 15, 41, 1, 1),
(19, '2015-04-06', 15, 96, 3, 1),
(20, '2015-04-06', 15, 116, 1, 1),
(21, '2015-04-06', 15, 87, 3, 1),
(22, '2015-04-06', 15, 8, 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `shop_payment`
--

CREATE TABLE IF NOT EXISTS `shop_payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_name` varchar(255) NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `shop_payment`
--

INSERT INTO `shop_payment` (`payment_id`, `payment_name`) VALUES
(1, 'Cash'),
(2, 'By written order'),
(3, 'Webmoney');

-- --------------------------------------------------------

--
-- Структура таблицы `shop_status`
--

CREATE TABLE IF NOT EXISTS `shop_status` (
  `id_status` int(11) NOT NULL,
  `name_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `shop_status`
--

INSERT INTO `shop_status` (`id_status`, `name_status`) VALUES
(1, 'in work'),
(2, 'in transit'),
(3, 'complite');

-- --------------------------------------------------------

--
-- Структура таблицы `shop_users`
--

CREATE TABLE IF NOT EXISTS `shop_users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `login_user` varchar(60) NOT NULL,
  `password_user` varchar(255) NOT NULL,
  `mail_user` varchar(255) NOT NULL,
  `key_user` varchar(10) NOT NULL,
  `code_user` varchar(10) NOT NULL,
  `discount_user` int(11) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `shop_users`
--

INSERT INTO `shop_users` (`id_user`, `login_user`, `password_user`, `mail_user`, `key_user`, `code_user`, `discount_user`) VALUES
(1, 'test', '111111111', 'test@test.com', '1111111111', '', 30),
(2, 'test2', '22222222', '1', '', '', 0),
(3, 'test3', 'e49b3fc475c1f7ea890b137824b59dbd', '1', 'imbaaf9878', '', 0),
(4, 'test4', 'a85982e9d0260044c41f68a9f84bd370', '1', '5bm5mm5emm', '', 0),
(5, 'igor@ggd.com', '91ec2994a98a7b8798460f83d83ec240', '1', 'dm4706eae4', '', 0),
(6, 'igorrr', '9e82c4c9c181630f395fcdf50cfa6c2d', '1', '73ecm3i3aa', '', 0),
(7, 'igorrrr', '3127f0a4eaa957617855fbc16fd4c833', 'igor@ggd.com', '3b38b837b1', '', 0),
(8, 'igigigigigi', '9d497727df4a9123d86fbddfc7402bf6', 'asdf@asdf.com', '4ade31a616', '', 0),
(9, 'somememe', '60a7cbdb0a5bb66518630894c59a3dbe', 'igor@ggd.com', 'if73130i11', '', 0),
(10, 'qwerqwer', 'f24ff641c7e33c00788292dd09251df4', 'asdf@asdf.com', '4d7073788d', '', 0),
(11, 'lalalala', '4a3ba401055b0fc2f054e47edd57f7cf', 'lalalal@li.com', '541f8i1mi6', '', 0),
(12, 'sadfsdf', 'ef6f99b4d4834f602133b68ecb4a27fa', 'sasdf@sadf.com', '40d6m0ibba', '', 0),
(13, 'oioioi', '4c6f94cfd6c7dacd812258b15a5cfd88', 'sasdf@asdf.com', '6c0aee594c', '', 0),
(14, 'igorrr', '69528ae085e787df414f7b449d03792b', 'asdf@assdf.com', 'mmimidcm24', '', 0),
(15, 'skivuha', '34aaec82224fa9c639dcfc6f97c2d841', 'skivuha@hotmail.com', '04fb50511d', '3936870438', 30),
(16, 'Igor', 'e0cfb675a6e04c19b993b6370350199d', 'skive@live.ru', '7eebi24ab7', '', 0),
(17, 'Igor', '36152bc817ecf370dd47906cad2d47ad', 'igor@hotmail.com', '7d17i8d7bm', '', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
