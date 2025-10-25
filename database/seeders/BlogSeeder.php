<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\Blog;
use App\Models\BlogComment;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Categories
        $travelTips = BlogCategory::create([
            'name' => 'Travel Tips',
            'description' => 'Helpful tips and advice for travelers'
        ]);

        $destinations = BlogCategory::create([
            'name' => 'Destinations',
            'description' => 'Discover amazing places around the world'
        ]);

        $guides = BlogCategory::create([
            'name' => 'Travel Guides',
            'description' => 'Comprehensive travel guides for various destinations'
        ]);

        // Create Tags
        $adventure = BlogTag::create(['name' => 'Adventure']);
        $budgetTravel = BlogTag::create(['name' => 'Budget Travel']);
        $luxury = BlogTag::create(['name' => 'Luxury']);
        $foodie = BlogTag::create(['name' => 'Foodie']);
        $culture = BlogTag::create(['name' => 'Culture']);
        $photography = BlogTag::create(['name' => 'Photography']);

        // Blog Post 1
        $blog1 = Blog::create([
            'title' => '10 Essential Tips for Your First International Trip',
            'excerpt' => 'Planning your first international adventure? Here are the essential tips you need to know before you go.',
            'content' => '<p>Traveling internationally for the first time can be both exciting and overwhelming. Here are 10 essential tips to help make your first international trip a success.</p>

<h3>1. Check Your Passport Validity</h3>
<p>Many countries require your passport to be valid for at least 6 months beyond your planned return date. Check this well in advance of your trip.</p>

<h3>2. Research Visa Requirements</h3>
<p>Different countries have different visa requirements. Some allow visa-free entry, while others require advance application. Research this early!</p>

<h3>3. Notify Your Bank</h3>
<p>Let your bank and credit card companies know about your travel plans to avoid having your cards frozen for suspicious activity.</p>

<h3>4. Get Travel Insurance</h3>
<p>Travel insurance can save you thousands if something goes wrong. It\'s worth the peace of mind.</p>

<h3>5. Learn Basic Local Phrases</h3>
<p>Even just learning "hello," "thank you," and "excuse me" in the local language goes a long way.</p>

<h3>6. Pack Light</h3>
<p>You don\'t need as much as you think. Pack versatile items and plan to do laundry if needed.</p>

<h3>7. Make Copies of Important Documents</h3>
<p>Keep digital and physical copies of your passport, visa, insurance, and other important documents.</p>

<h3>8. Download Offline Maps</h3>
<p>Google Maps allows you to download maps for offline use. This is invaluable when you don\'t have data.</p>

<h3>9. Be Aware of Local Customs</h3>
<p>Research local customs and etiquette to avoid accidentally offending anyone.</p>

<h3>10. Stay Flexible</h3>
<p>Things rarely go exactly as planned when traveling. Stay flexible and embrace the unexpected!</p>',
            'blog_category_id' => $travelTips->id,
            'author_name' => 'Sarah Johnson',
            'author_bio' => 'Travel blogger and adventurer who has visited over 50 countries. Passionate about helping others explore the world.',
            'is_published' => true,
            'published_at' => now()->subDays(5),
            'views_count' => 245,
        ]);
        $blog1->tags()->attach([$adventure->id, $budgetTravel->id]);

        // Blog Post 2
        $blog2 = Blog::create([
            'title' => 'Hidden Gems of Southeast Asia You Must Visit',
            'excerpt' => 'Move beyond the tourist hotspots and discover these incredible hidden gems across Southeast Asia.',
            'content' => '<p>Southeast Asia is known for its beautiful beaches, vibrant cities, and rich culture. But beyond the well-trodden tourist paths lie some incredible hidden gems waiting to be discovered.</p>

<h3>Kampot, Cambodia</h3>
<p>This riverside town offers a relaxed atmosphere, French colonial architecture, and stunning sunset views over the river.</p>

<h3>Pai, Thailand</h3>
<p>Nestled in the mountains of Northern Thailand, Pai is a backpacker\'s paradise with waterfalls, hot springs, and a bohemian vibe.</p>

<h3>Koh Rong Sanloem, Cambodia</h3>
<p>For pristine beaches without the crowds, this island paradise is perfect. Crystal clear water and bioluminescent plankton await.</p>

<h3>Luang Prabang, Laos</h3>
<p>This UNESCO World Heritage site combines stunning temples, French colonial architecture, and natural beauty including the famous Kuang Si Falls.</p>

<h3>Banaue Rice Terraces, Philippines</h3>
<p>These 2,000-year-old rice terraces carved into the mountains are a testament to human ingenuity and offer breathtaking views.</p>

<p>Each of these destinations offers a unique experience away from the typical tourist circuit. They provide authentic cultural experiences and natural beauty that will make your Southeast Asian adventure truly memorable.</p>',
            'blog_category_id' => $destinations->id,
            'author_name' => 'Michael Chen',
            'author_bio' => 'Adventure photographer and Southeast Asia specialist. Living in Thailand for the past 8 years.',
            'is_published' => true,
            'published_at' => now()->subDays(3),
            'views_count' => 312,
        ]);
        $blog2->tags()->attach([$adventure->id, $culture->id, $photography->id]);

        // Blog Post 3
        $blog3 = Blog::create([
            'title' => 'The Ultimate Guide to Budget Travel in Europe',
            'excerpt' => 'Europe doesn\'t have to break the bank. Learn how to explore this amazing continent on a budget.',
            'content' => '<p>Many people think Europe is too expensive for budget travelers, but with the right strategies, you can explore this incredible continent without breaking the bank.</p>

<h3>Transportation</h3>
<p>Skip expensive flights between cities and opt for budget airlines, buses, or trains. The Eurail pass can be great value if you\'re visiting multiple countries.</p>

<h3>Accommodation</h3>
<p>Hostels aren\'t just for young backpackers anymore. Many offer private rooms at affordable prices. Consider Airbnb or house-sitting for longer stays.</p>

<h3>Food</h3>
<p>Eat like a local! Shop at markets, cook your own meals, and enjoy picnics in beautiful parks. When dining out, look for lunch specials which are often much cheaper than dinner.</p>

<h3>Free Attractions</h3>
<p>Many museums offer free entry on certain days. Parks, churches, and street performances are always free and often the most memorable experiences.</p>

<h3>Best Budget Destinations</h3>
<p>Eastern Europe (Poland, Hungary, Romania) and Southern Europe (Portugal, Greece) offer incredible value. You can live well on $50-70 per day in these regions.</p>

<h3>Timing</h3>
<p>Travel in shoulder season (April-May, September-October) for better prices and fewer crowds while still enjoying good weather.</p>',
            'blog_category_id' => $guides->id,
            'author_name' => 'Emma Martinez',
            'author_bio' => 'Budget travel expert who spent a year traveling Europe on $20,000. Now helping others do the same.',
            'is_published' => true,
            'published_at' => now()->subDays(7),
            'views_count' => 428,
        ]);
        $blog3->tags()->attach([$budgetTravel->id, $culture->id]);

        // Blog Post 4
        $blog4 = Blog::create([
            'title' => 'Top 5 Food Destinations Every Foodie Must Visit',
            'excerpt' => 'For travelers who eat to live, these destinations offer unforgettable culinary experiences.',
            'content' => '<p>If you\'re a foodie traveler, these destinations should be at the top of your bucket list. Each offers unique flavors and unforgettable dining experiences.</p>

<h3>1. Bangkok, Thailand</h3>
<p>Street food heaven! From pad thai to mango sticky rice, Bangkok\'s food scene is unmatched. Don\'t miss the night markets.</p>

<h3>2. Lyon, France</h3>
<p>Often overlooked for Paris, Lyon is considered the gastronomic capital of France. The bouchons serve traditional Lyonnaise cuisine that will blow your mind.</p>

<h3>3. Tokyo, Japan</h3>
<p>With more Michelin stars than any other city, Tokyo offers everything from $3 ramen to $300 sushi. Every meal is an experience.</p>

<h3>4. Oaxaca, Mexico</h3>
<p>The birthplace of mole and home to incredible street food, markets, and mezcal. A true foodie paradise.</p>

<h3>5. Istanbul, Turkey</h3>
<p>Where East meets West, the food reflects this beautiful fusion. From kebabs to baklava, every bite tells a story.</p>

<p>Each of these destinations offers not just great food, but also food tours, cooking classes, and market visits that will deepen your appreciation for local cuisine.</p>',
            'blog_category_id' => $destinations->id,
            'author_name' => 'David Kim',
            'author_bio' => 'Chef turned food blogger. Traveling the world one bite at a time.',
            'is_published' => true,
            'published_at' => now()->subDays(1),
            'views_count' => 156,
        ]);
        $blog4->tags()->attach([$foodie->id, $culture->id, $luxury->id]);

        // Add some comments to the first blog post
        BlogComment::create([
            'blog_id' => $blog1->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'comment' => 'Great tips! I\'m planning my first trip to Europe next year and this really helped.',
            'is_approved' => true,
        ]);

        BlogComment::create([
            'blog_id' => $blog1->id,
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'comment' => 'The passport validity tip saved me! I almost missed my trip because of this.',
            'is_approved' => true,
        ]);

        BlogComment::create([
            'blog_id' => $blog1->id,
            'name' => 'Bob Wilson',
            'email' => 'bob@example.com',
            'comment' => 'This comment is waiting for approval.',
            'is_approved' => false,
        ]);

        // Add comments to second blog post
        BlogComment::create([
            'blog_id' => $blog2->id,
            'name' => 'Alice Brown',
            'email' => 'alice@example.com',
            'comment' => 'Luang Prabang is absolutely stunning! Highly recommend the morning alms ceremony.',
            'is_approved' => true,
        ]);

        BlogComment::create([
            'blog_id' => $blog3->id,
            'name' => 'Carlos Rodriguez',
            'email' => 'carlos@example.com',
            'comment' => 'Used these tips for my Eastern Europe trip and saved so much money. Thanks!',
            'is_approved' => true,
        ]);

        $this->command->info('Blog seeder completed successfully!');
    }
}
