<?php

use App\Models\Event;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('events')) {
            return;
        }

        $now = now();
        $event = DB::table('events')->where('slug', 'logisphere-bengaluru-2026')->first()
            ?? DB::table('events')->where('name', 'LOGISPHERE')->orderBy('id')->first();

        if (! $event) {
            $eventId = DB::table('events')->insertGetId([
                'slug' => 'logisphere-bengaluru-2026',
                'name' => 'LOGISPHERE',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        } else {
            $eventId = $event->id;
        }

        $eventData = [
            'slug' => 'logisphere-bengaluru-2026',
            'name' => 'LOGISPHERE',
            'chapter' => 'Chapter 1: Bengaluru Edition',
            'tagline' => 'One Sphere. Infinite Supply Chain Possibilities.',
            'event_date' => '2026-08-28',
            'event_time' => 'One-Day Executive Conclave',
            'location' => 'Bengaluru, Karnataka, India',
            'format' => 'High-impact curated executive conclave',
            'welcome_note' => "\"Infinite supply chain possibilities do not come from infinite budget. They come from the right people, in the right room, asking the right questions.\"\n\nThat room is LogiSphere.\n\nJoin us on 28th August 2026 in Bengaluru and be part of the conversation that shapes the future of India's supply chains.",
            'about' => "LogiSphere - Chapter 1: Bengaluru Edition is a high-impact executive conclave designed to bring together supply chain leaders, technology innovators, operations experts, startups, and decision-makers on one focused, curated platform.\n\nConceived and curated by Ananth Decodes Logistics, the event is built on a simple but powerful belief: the best business outcomes emerge not from scale, but from depth of conversation and quality of connection.\n\nUnlike traditional conferences that prioritise volume over value, LogiSphere is engineered as a conversation-driven ecosystem where participants exchange practical insights, explore emerging trends, challenge conventional thinking, and build strategic relationships that translate into real business impact.",
            'why_now' => "Bengaluru is not just India's technology capital. It is the nerve centre of the country's most ambitious supply chain, logistics, and operations transformation stories. Chapter 1 begins here because the city brings together global enterprise leadership, manufacturing corridors, logistics technology clusters, venture-backed startups, innovation labs, policy associations, and senior decision-makers in one dense ecosystem.",
            'theme_title' => 'From Visibility to Velocity',
            'theme_points' => json_encode([
                'AI-native supply chains: real-time decision intelligence, demand sensing, and autonomous logistics at scale.',
                'Platform-led logistics models: aggregator platforms, marketplace logistics, and API-first ecosystems.',
                'Sustainable supply chains: carbon accounting, circular logistics, ESG, and green logistics as competitive advantage.',
                "India's role in global supply chains: policy tailwinds, structural shifts, capability gaps, and global opportunity.",
                'Profitability vs. scale: balancing growth ambition with unit economics in logistics.',
                'Leadership alignment: C-suite alignment and strategic organisational design.',
                'Talent transformation: building supply chain professionals for automation and rapid change.',
            ]),
            'comparison_rows' => json_encode([
                ['traditional' => 'Volume-led conferences with passive attendance', 'logisphere' => 'Curated, executive-level conversations with business intent'],
                ['traditional' => 'Broad, generic networking', 'logisphere' => 'Vetted delegates with seniority, relevance, and decision-making authority'],
                ['traditional' => 'Surface-level commentary', 'logisphere' => 'Substantive, data-backed discourse and implementation-ready takeaways'],
                ['traditional' => 'Exhibition as a side activity', 'logisphere' => 'Exhibition embedded into the event flow for meaningful engagement'],
            ]),
            'attendee_profiles' => json_encode([
                'CEOs, COOs, CSCOs, and enterprise leaders driving supply chain strategy and investment decisions',
                'Heads of supply chain and logistics responsible for end-to-end performance and transformation',
                'Procurement leaders, CPOs, and sourcing heads overseeing vendor selection and category management',
                'Technology founders and product leaders building supply chain and logistics technology',
                'Policy advisors, associations, and influencers shaping the regulatory and strategic landscape',
                'Senior professionals from manufacturing, FMCG, retail, e-commerce, pharmaceuticals, automotive, logistics, and logistics technology',
            ]),
            'exhibitor_intro' => "The LogiSphere exhibition floor offers a highly focused, distraction-free environment where technology providers, solution companies, and service firms can demonstrate capabilities to a curated audience of senior supply chain decision-makers.",
            'exhibitor_benefits' => json_encode([
                'Dedicated branded booth space on the exhibition floor',
                'Standard table and chairs for demos, literature, and one-on-one conversations',
                'Complimentary booth staff passes with access to sessions, networking, lunch, and cocktail dinner',
                'Full integration into the delegate experience across all event formats',
                'Ideal for logistics tech, warehouse automation, SaaS platforms, consulting firms, transportation, freight, and sustainability solutions',
            ]),
            'exhibitor_profile' => 'Ideal exhibiting organisations include logistics technology companies, warehouse automation firms, SaaS platforms, consulting firms, transportation and freight providers, and sustainability solution companies.',
            'exhibitor_package_notes' => json_encode([
                'Dedicated booth and qualified lead generation',
                'Networking access with full delegate integration',
                'Exhibition Partner investment: INR 3,00,000 + GST',
                '40 slots available',
            ]),
            'sponsor_intro' => "LogiSphere is not a mass-market event. It is a precision-engineered sponsorship platform that enables your brand to engage directly and meaningfully with senior professionals who influence strategic purchasing decisions, technology adoption, and organisational transformation.",
            'sponsor_benefits' => json_encode([
                'Premium brand visibility across stage, venue, collateral, digital assets, and social media',
                'Qualified lead generation through opted-in senior professionals',
                'Thought leadership through speaking slots, panel participation, and content association',
                'Strategic relationship-building with prospective clients, partners, and industry influencers',
                'Market intelligence from enterprise supply chain leaders',
                'Live product demonstrations to a high-intent audience',
            ]),
            'sponsor_inclusions' => json_encode([
                'Logo and visual branding across event creatives, website, delegate kits, and printed collateral',
                'On-stage and venue branding across backdrops, signage, registration desk, and session areas',
                'Speaking, panel, keynote, or moderator opportunities based on sponsorship tier',
                'Post-event access to opted-in delegate leads where applicable',
                'LinkedIn, Instagram, email, PR, media, and on-ground promotional visibility',
                'Professional photo and video documentation with sponsor brand visibility',
                'Complimentary full-access delegate passes based on tier',
            ]),
            'contact_email' => 'sunil@ananthdecodeslogistics.com',
            'contact_note' => "Primary Contact: Sunil J - +91 90089 29929 - sunil@ananthdecodeslogistics.com\nSponsorship: Jesu Raj - +91 98869 44994 - jesu@ananthdecodeslogistics.com\nWebsite: www.ananthdecodeslogistics.com\n\nFor time-sensitive sponsorship category enquiries, email is the fastest way to initiate a conversation. Category exclusivity is confirmed on a first-come, first-served basis.",
            'interest_options' => json_encode(Event::defaultInterestOptions()),
            'closing_note' => "\"Infinite supply chain possibilities do not come from infinite budget. They come from the right people, in the right room, asking the right questions.\"\n\nThat room is LogiSphere.",
            'why_who_eyebrow' => 'Location Strategy',
            'why_who_heading' => 'Why Bengaluru?',
            'why_who_subheading' => "India's supply chain innovation capital is the logical birthplace for Chapter 1.",
            'sponsorship_eyebrow' => 'Partner With Us',
            'sponsorship_heading' => 'Sponsor, exhibit, and shape the room',
            'sponsorship_subheading' => 'Precision sponsorship for brands seeking senior supply chain decision-makers, qualified leads, thought leadership, and strategic relationships.',
            'registration_eyebrow' => 'Register Interest',
            'registration_heading' => 'Join LogiSphere Bengaluru',
            'registration_subheading' => 'Register interest as a delegate, speaker, sponsor, or exhibitor for 28th August 2026 at Taj MG Road, Bengaluru.',
            'registration_panel_eyebrow' => 'Contact Us',
            'registration_panel_heading' => 'The LogiSphere team will follow up.',
            'registration_form_heading' => 'Register Interest',
            'registration_form_subheading' => 'Tell us how you want to participate in LogiSphere.',
            'registration_steps' => json_encode([
                ['title' => 'Submit your interest', 'text' => 'Choose delegate, speaker, sponsor, or exhibitor and share your details.'],
                ['title' => 'Team review', 'text' => 'The event team checks fit, category availability, and the right next step.'],
                ['title' => 'Confirmation', 'text' => 'Approved delegates and partners receive event coordination details.'],
            ]),
            'active_sponsor_currency' => 'INR',
            'tax_label' => 'GST',
            'tax_percentage' => 18,
            'meta_title' => 'LogiSphere Bengaluru 2026 - Ananth Decodes Logistics',
            'meta_description' => 'LogiSphere Bengaluru Edition is a one-day executive supply chain conclave on 28th August 2026 at Taj MG Road, Bengaluru.',
            'updated_at' => $now,
        ];

        if (Schema::hasColumn('events', 'venue_name')) {
            $eventData['venue_name'] = 'Taj MG Road';
        }

        if (Schema::hasColumn('events', 'venue_address')) {
            $eventData['venue_address'] = 'Taj MG Road, Bengaluru, Karnataka, India';
        }

        if (Schema::hasColumn('events', 'venue_map_embed')) {
            $eventData['venue_map_embed'] = 'https://www.google.com/maps?q=Taj%20MG%20Road%20Bengaluru&output=embed';
        }

        DB::table('events')->where('id', $eventId)->update($eventData);

        if (Schema::hasTable('event_sponsor_packages')) {
            DB::table('event_sponsor_packages')->where('event_id', $eventId)->update(['visible' => false, 'updated_at' => $now]);

            $packages = [
                ['Title Sponsor', 'title-sponsor', 1, 3000000, 0, 15, 'Category-exclusive, maximum visibility partnership.', ['Maximum brand visibility', 'Category exclusivity', 'Highest level of strategic integration', 'Priority stage and venue branding']],
                ['Powered By Sponsor', 'powered-by-sponsor', 1, 2000000, 0, 12, 'Prominent branding with keynote speaking rights.', ['Prominent stage branding', 'Keynote speaking opportunity', 'Premium event communication visibility', 'Marketing material positioning']],
                ['Associate Sponsor', 'associate-sponsor', 4, 1000000, 0, 8, 'High-visibility digital and on-ground association.', ['Digital and venue visibility', 'Speaking representation', 'Broad brand association', 'Delegate engagement opportunities']],
                ['Session Sponsor', 'session-sponsor', 8, 500000, 0, 4, 'Ownership of a curated seminar or panel session with full session branding.', ['Session ownership', 'Introduction rights', 'Content co-creation', 'Full session branding']],
                ['Networking Sponsor', 'networking-sponsor', 3, 300000, 0, 3, 'Exclusive branding at breakfast, lunch, and cocktail dinner.', ['Exclusive networking branding', 'Relationship-driven engagement', 'Visibility across breakfast, lunch, and cocktail dinner', 'Delegate interaction access']],
                ['Exhibition Partner', 'exhibition-partner', 40, 300000, 0, 2, 'Dedicated booth and qualified lead generation.', ['Dedicated branded booth', 'Qualified lead generation', 'Networking access', 'Full delegate integration']],
            ];

            foreach ($packages as $index => [$name, $slug, $slots, $inr, $usd, $passes, $description, $benefits]) {
                DB::table('event_sponsor_packages')->updateOrInsert(
                    ['event_id' => $eventId, 'slug' => $slug],
                    [
                        'name' => $name,
                        'slot_count' => $slots,
                        'price_inr' => $inr,
                        'price_usd' => $usd,
                        'included_passes' => $passes,
                        'description' => $description,
                        'benefits' => json_encode($benefits),
                        'sort_order' => $index,
                        'visible' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
        }

        if (Schema::hasTable('event_agenda_items')) {
            DB::table('event_agenda_items')->where('event_id', $eventId)->delete();
            $agenda = [
                ['08:30 AM', '09:30 AM', '60 minutes', 'Networking', 'Business Breakfast & Registration', 'Delegate check-in, breakfast networking, and exhibition access.'],
                ['09:30 AM', '09:45 AM', '15 minutes', 'Opening', 'Welcome Address', 'Opening remarks by Ananth Decodes Logistics.'],
                ['10:00 AM', '10:45 AM', '45 minutes', 'Seminar', 'From Visibility to Velocity', 'A practitioner-led session on moving from dashboards to decision intelligence and execution velocity.'],
                ['11:00 AM', '11:45 AM', '45 minutes', 'Panel Discussion', 'AI-Native Supply Chains', 'How enterprises are embedding AI as the operating system of supply chain transformation.'],
                ['12:00 PM', '12:45 PM', '45 minutes', 'Panel Discussion', 'Profitability vs. Scale', 'Navigating growth ambition, unit economics, and operational discipline in logistics.'],
                ['01:00 PM', '02:15 PM', '75 minutes', 'Networking', 'Curated Lunch & Exhibition Showcase', 'Focused networking and solution demonstrations across the exhibition floor.'],
                ['02:30 PM', '03:15 PM', '45 minutes', 'Seminar', "India's Role in Global Supply Chains", 'Structural shifts, policy tailwinds, capability gaps, and the global opportunity for India.'],
                ['03:30 PM', '04:15 PM', '45 minutes', 'Panel Discussion', 'Sustainable Supply Chains', 'ESG, carbon accounting, circular logistics, and green logistics as competitive advantage.'],
                ['06:30 PM', '08:30 PM', '120 minutes', 'Premium Networking', 'Cocktail Dinner & Premium Networking', 'Relationship-led networking with delegates, sponsors, exhibitors, and speakers.'],
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
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        if (Schema::hasTable('event_faqs')) {
            DB::table('event_faqs')->where('event_id', $eventId)->delete();
            $faqs = [
                ['When and where is LogiSphere Bengaluru Edition?', 'LogiSphere is scheduled for 28th August 2026 at Taj MG Road, Bengaluru, Karnataka, India.'],
                ['Who should attend?', 'The event is designed for CXOs, supply chain heads, logistics leaders, procurement leaders, technology founders, innovators, policy advisors, associations, and senior professionals from manufacturing, FMCG, retail, e-commerce, pharmaceuticals, automotive, logistics, and logistics technology.'],
                ['How many delegates are expected?', 'The event is curated for 250-300 senior professionals representing 100+ companies.'],
                ['What sponsorship categories are available?', 'Title Sponsor, Powered By Sponsor, Associate Sponsor, Session Sponsor, Networking Sponsor, and Exhibition Partner categories are available. Category exclusivity is confirmed on a first-come, first-served basis.'],
                ['What is included for exhibitors?', 'Exhibitors receive dedicated branded booth space, furniture and fittings, booth staff passes, networking access, and integration into the delegate experience.'],
                ['Who do I contact for sponsorship?', 'For primary enquiries contact Sunil J at +91 90089 29929 or sunil@ananthdecodeslogistics.com. For sponsorship enquiries contact Jesu Raj at +91 98869 44994 or jesu@ananthdecodeslogistics.com.'],
            ];

            foreach ($faqs as $index => [$question, $answer]) {
                DB::table('event_faqs')->insert([
                    'event_id' => $eventId,
                    'question' => $question,
                    'answer' => $answer,
                    'sort_order' => $index,
                    'visible' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        // Content-only migration. Keeping the current event copy is safer than restoring stale brochure data.
    }
};
