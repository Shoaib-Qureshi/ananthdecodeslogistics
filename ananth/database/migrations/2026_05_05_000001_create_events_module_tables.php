<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name')->default('LOGISPHERE');
            $table->string('chapter')->nullable();
            $table->string('tagline')->nullable();
            $table->date('event_date')->nullable();
            $table->string('event_time')->nullable();
            $table->string('location')->nullable();
            $table->string('format')->nullable();
            $table->string('hero_image')->nullable();
            $table->longText('welcome_note')->nullable();
            $table->longText('about')->nullable();
            $table->longText('why_now')->nullable();
            $table->string('theme_title')->nullable();
            $table->json('theme_points')->nullable();
            $table->json('comparison_rows')->nullable();
            $table->json('attendee_profiles')->nullable();
            $table->longText('exhibitor_intro')->nullable();
            $table->json('exhibitor_benefits')->nullable();
            $table->longText('exhibitor_profile')->nullable();
            $table->json('exhibitor_package_notes')->nullable();
            $table->longText('sponsor_intro')->nullable();
            $table->json('sponsor_benefits')->nullable();
            $table->json('sponsor_inclusions')->nullable();
            $table->string('contact_email')->nullable();
            $table->longText('contact_note')->nullable();
            $table->longText('closing_note')->nullable();
            $table->string('active_sponsor_currency', 3)->default('INR');
            $table->string('tax_label')->default('GST');
            $table->decimal('tax_percentage', 5, 2)->default(18);
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('canonical_url')->nullable();
            $table->timestamps();
        });

        Schema::create('event_agenda_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('duration')->nullable();
            $table->string('session_type')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('visible')->default(true);
            $table->timestamps();
        });

        Schema::create('event_faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->string('question');
            $table->text('answer')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('visible')->default(true);
            $table->timestamps();
        });

        Schema::create('event_sponsor_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->unsignedInteger('slot_count')->default(1);
            $table->decimal('price_inr', 12, 2)->default(0);
            $table->decimal('price_usd', 12, 2)->default(0);
            $table->unsignedInteger('included_passes')->default(0);
            $table->text('description')->nullable();
            $table->json('benefits')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('visible')->default(true);
            $table->timestamps();
            $table->unique(['event_id', 'slug']);
        });

        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->string('inquiry_type')->default('delegate');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('designation')->nullable();
            $table->text('message')->nullable();
            $table->boolean('consent')->default(false);
            $table->string('status')->default('new');
            $table->timestamps();
        });

        Schema::create('event_sponsor_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->foreignId('sponsor_package_id')->constrained('event_sponsor_packages')->cascadeOnDelete();
            $table->string('company');
            $table->string('contact_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('billing_address')->nullable();
            $table->string('gst_number')->nullable();
            $table->string('currency', 3);
            $table->decimal('base_amount', 12, 2);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);
            $table->decimal('tax_percentage', 5, 2)->default(0);
            $table->string('tax_label')->nullable();
            $table->string('status')->default('pending');
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_signature')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        $this->seedDefaults();
    }

    public function down(): void
    {
        Schema::dropIfExists('event_sponsor_payments');
        Schema::dropIfExists('event_registrations');
        Schema::dropIfExists('event_sponsor_packages');
        Schema::dropIfExists('event_faqs');
        Schema::dropIfExists('event_agenda_items');
        Schema::dropIfExists('events');
    }

    private function seedDefaults(): void
    {
        $eventId = DB::table('events')->insertGetId([
            'slug' => 'logisphere-bengaluru-2026',
            'name' => 'LOGISPHERE',
            'chapter' => 'Chapter 1: Bengaluru Edition',
            'tagline' => 'One Sphere. Infinite Supply Chain Possibilities.',
            'event_date' => '2026-08-07',
            'event_time' => 'A one-day, high-impact executive conclave',
            'location' => 'Bengaluru',
            'format' => 'Executive conclave',
            'welcome_note' => "\"Supply chains are no longer linear. They are living, breathing networks of data, decisions, and human ingenuity.\n\nLogiSphere is not another conference. It is a convergence of those who refuse to accept 'business as usual.'\n\nOne sphere. One day. Infinite possibilities.\"",
            'about' => "LogiSphere - Chapter 1: Bengaluru Edition is an exclusive, invitation-focused supply chain summit curated by Ananth Decodes Logistics.\n\nThis one-day event brings together a select group of supply chain leaders, tech founders, and operations excellence champions to explore how Indian enterprises can move from reactive logistics to predictive, resilient, and autonomous supply chains.\n\nUnlike traditional summits, LogiSphere is deliberately compact, conversation-driven, and action-oriented.",
            'why_now' => "Bengaluru - India's deep tech and startup capital - is the natural birthplace for Chapter 1.",
            'theme_title' => 'From Visibility to Velocity',
            'theme_points' => json_encode(['Autonomous decision-making', 'AI-native operations', 'Green logistics without premium pricing', 'Port-to-porch predictability']),
            'comparison_rows' => json_encode([
                ['traditional' => 'Many speakers, little depth', 'logisphere' => 'Fewer voices, high signal'],
                ['traditional' => 'Generic panels', 'logisphere' => 'Gated, curated dialogues'],
                ['traditional' => 'Passive listening', 'logisphere' => 'Active problem-solving'],
                ['traditional' => 'One-size-fits-all', 'logisphere' => 'Chapter-based hyperlocal context'],
            ]),
            'attendee_profiles' => json_encode([
                'CXOs, VPs, and heads of supply chain from manufacturing, retail, e-commerce, FMCG, pharma, and automotive',
                'Founders and product leaders in logistics tech, warehousing automation, and freight marketplaces',
                'Policy advisors and trade body representatives',
                'Operations excellence professionals who build, not just manage',
            ]),
            'exhibitor_intro' => 'LogiSphere is not a large, noisy exhibition. It is a precision engagement platform.',
            'exhibitor_benefits' => json_encode(['Showcase innovations', 'Enhance visibility', 'Connect with key stakeholders', 'Explore business opportunities', 'Gain industry insights', 'Showcase sustainability']),
            'exhibitor_profile' => 'Connect with supply chain leaders, CXOs, policymakers, heads of demand planning, inventory management, procurement, manufacturing, operations, packaging, QC, logistics, transportation, warehouse, customer service, tech innovators, and global buyers.',
            'exhibitor_package_notes' => json_encode(['Booth space size to be updated', '2 Chairs', '1 Table with Branding', 'Each exhibitor receives 2 delegate passes', 'Designs must be shared 7 days before the event in PDF format']),
            'sponsor_intro' => 'Position your brand alongside top industry leaders and decision-makers. Sponsorship packages offer visibility, lead generation, and brand engagement with supply chain and logistics professionals.',
            'sponsor_benefits' => json_encode(['Engage with India\'s vision for the future', 'Influence industry trends', 'Expand your network', 'Engage with industry leaders', 'Showcase your expertise']),
            'sponsor_inclusions' => json_encode(['All sessions', 'Access to curated networking zones', 'Lunch, coffee, and delegate kit', 'Post-event access to select speaker presentations']),
            'contact_email' => 'jana.ananthakrishnan@gmail.com',
            'contact_note' => "Speaking / Agenda: Mention \"Speaker - LogiSphere\" in the subject line.\nSponsorship / Exhibition: Mention \"Partnership - LogiSphere\".\nDelegate booking: Mention \"Delegate - LogiSphere\".",
            'closing_note' => "\"Infinite supply chain possibilities do not come from infinite budget. They come from the right people, in the right room, asking the right questions.\n\nThat room is LogiSphere.\"\n- Ananth",
            'meta_title' => 'LogiSphere Bengaluru 2026 - Ananth Decodes Logistics',
            'meta_description' => 'A one-day executive supply chain conclave in Bengaluru by Ananth Decodes Logistics.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $packages = [
            ['Co-Powered', 'co-powered', 1, 1500000, 20000, 15],
            ['Diamond', 'diamond', 2, 1200000, 16000, 12],
            ['Platinum', 'platinum', 5, 1000000, 13500, 10],
            ['Gold', 'gold', 10, 700000, 9400, 5],
            ['Silver', 'silver', 15, 500000, 6700, 3],
        ];

        foreach ($packages as $index => [$name, $slug, $slots, $inr, $usd, $passes]) {
            DB::table('event_sponsor_packages')->insert([
                'event_id' => $eventId,
                'name' => $name,
                'slug' => $slug,
                'slot_count' => $slots,
                'price_inr' => $inr,
                'price_usd' => $usd,
                'included_passes' => $passes,
                'description' => 'Premium brand positioning across LogiSphere 2026.',
                'benefits' => json_encode(['Conference access', 'Logo visibility on sponsor page', 'Brand recognition in event communication', 'Event brochure visibility']),
                'sort_order' => $index,
                'visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $agenda = [
            ['10:30 AM', '11:00 AM', '30 minutes', null, 'Registration', null],
            ['11:00 AM', '11:05 AM', '5 minutes', null, 'Welcome Address', null],
            ['11:15 AM', '12:00 PM', '45 minutes', 'Seminar', 'From Cost Center to Strategic Engine: Repositioning Logistics in the Boardroom', 'How logistics is no longer a support function but a driver of growth, resilience, and competitive advantage.'],
            ['12:10 PM', '12:40 PM', '30 minutes', 'Panel Discussion', 'Speed vs Profitability: Are We Scaling Inefficiencies?', null],
            ['12:50 PM', '01:20 PM', '30 minutes', 'Panel Discussion', 'India as a Global Supply Chain Hub: Opportunity or Overstatement?', null],
            ['02:10 PM', '03:10 PM', '60 minutes', null, 'Networking Lunch & Exhibition Visit', '40 stalls open.'],
            ['03:20 PM', '04:05 PM', '45 minutes', 'Seminar', 'The Next Decade of Supply Chains: Digital, Decentralized, and Sustainable', 'AI, platform ecosystems, green logistics, and the shift from linear to networked supply chains.'],
            ['08:00 PM', '10:00 PM', null, null, 'Cocktail Dinner & Premium Networking', null],
        ];

        foreach ($agenda as $index => [$start, $end, $duration, $type, $title, $description]) {
            DB::table('event_agenda_items')->insert([
                'event_id' => $eventId,
                'start_time' => $start,
                'end_time' => $end,
                'duration' => $duration,
                'session_type' => $type,
                'title' => $title,
                'description' => $description,
                'sort_order' => $index,
                'visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $faqs = [
            ['Who can attend LogiSphere?', 'LogiSphere is designed for senior supply chain leaders, founders, logistics tech teams, policy advisors, and operations excellence professionals.'],
            ['Is attendance open to everyone?', 'Attendance is limited so that the room stays curated, high-signal, and conversation-driven.'],
            ['Can my company sponsor or exhibit?', 'Yes. Use the sponsorship page to choose a package or submit sponsor/exhibitor interest through the registration form.'],
            ['Which currency will sponsors pay in?', 'Sponsors pay in the active currency selected by admin: INR or USD.'],
        ];

        foreach ($faqs as $index => [$question, $answer]) {
            DB::table('event_faqs')->insert([
                'event_id' => $eventId,
                'question' => $question,
                'answer' => $answer,
                'sort_order' => $index,
                'visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
};
