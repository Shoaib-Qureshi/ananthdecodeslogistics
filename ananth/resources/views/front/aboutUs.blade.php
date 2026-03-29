@extends('layouts.front')
@section('title', 'About Us | Ananth Decodes Logistics')
@section('description', '')
@section('img', asset('img/site-banner.jpg'))
@section('url', asset('about-us') . '/')

@section('content')
    <style>
        .highlight-blue {
            color: #0f6bdc; /* updated highlight tone */
        }
        .academicCard {
            background: transparent;
            color: #fff;
            padding: 10px 0;
        }
        .academicCard h3 {
            margin-bottom: 24px;
            color: #fff;
        }
        .academicCard .timeline {
            position: relative;
            padding-left: 26px;
        }
        .academicCard .timeline::before {
            content: "";
            position: absolute;
            left: 6px;
            top: 6px;
            bottom: 6px;
            width: 2px;
            background: rgba(255,255,255,0.4);
        }
        .academicCard .timeline-item {
            position: relative;
            padding: 0 0 24px 16px;
        }
        .academicCard .timeline-item:last-child {
            padding-bottom: 10px;
        }
        .academicCard .dot {
            position: absolute;
            left: -26px;
            top: 4px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #3882fa;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px rgba(56,130,250,0.2);
            z-index: 1;
        }
        .academicCard .content h4 {
            margin: 4px 0 6px;
            color: #3882fa;
            font-weight: 700;
            font-size: 1.1rem;
        }
        .academicCard .content .label {
            font-style: italic;
            font-size: 0.85rem;
            color: rgba(255,255,255,0.8);
            display: block;
            margin-bottom: 2px;
        }
        .academicCard .content p {
            margin: 0 0 0px;
            color: rgba(255,255,255,0.9);
            font-size: 0.9rem;
        }
    </style>
    @php
        // Use stored headings, but fall back to branded defaults with blue highlight and line breaks
        $heroHeading = $aboutContent['about_hero']->heading ?? null;
        if (!$heroHeading) {
            $heroHeading = 'Navigating the Future of <br><span class="highlight-blue">Logistics</span>';
        }

        $mainHeading = $aboutContent['about_main_heading']->heading ?? null;
        if (!$mainHeading) {
            $mainHeading = 'Over two decades of <br> <span class="highlight-blue">transport and logistics expertise.</span>';
        }
    @endphp
    <section class="heroBanner" style="background-image: url('{{ isset($aboutContent['about_hero']) && $aboutContent['about_hero']->image ? asset($aboutContent['about_hero']->image) : '/img/site/generative-ai-is-used-transport-goods.jpg' }}');">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="homeText">
                        <h1>{!! $heroHeading !!}</h1>
                        <p>{{ isset($aboutContent['about_hero']) && $aboutContent['about_hero']->subheading ? $aboutContent['about_hero']->subheading : 'From warehouse to world — we cover it all.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--<div class="tabs">-->
    <!--    <button class="leftTab tab activeTab" data-tab="about-us">About Us</button>-->
    <!--    <button class="rightTab tab" data-tab="executive-committee">Executive Committee</button>-->
    <!--</div>-->

    <section class="bothPadding tab-container">
        <div id="about-us" class="tab-content activeTab">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="aboutPageHead">
                            <h2>{!! $mainHeading !!}</h2>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-6 mt-4">
                        <div class="overviewCard">
                            <div class="founderImg">
                                <img src="{{ isset($aboutContent['founder_profile']) && $aboutContent['founder_profile']->image ? asset($aboutContent['founder_profile']->image) : '/img/site/anantha-profile.webp' }}" alt="">
                                <div>
                                    <h4>{{ isset($aboutContent['founder_profile']) && $aboutContent['founder_profile']->heading ? $aboutContent['founder_profile']->heading : 'Ananthakrishnan J' }}</h4>
                                    <span>{{ isset($aboutContent['founder_profile']) && $aboutContent['founder_profile']->subheading ? $aboutContent['founder_profile']->subheading : 'CEO and Founder' }}</span>
                                </div>
                            </div>
                            <p>{!! isset($aboutContent['founder_profile']) && $aboutContent['founder_profile']->content ? nl2br(e($aboutContent['founder_profile']->content)) : 'Visionary logistics leader with 25+ years of global experience driving innovation, efficiency, and sustainability in transport and facility management. Passionate about transformation, teamwork, and future-ready supply chains.' !!}</p>

                            <div class="footerSocial">
                                <ul>
                                    <li><a href="https://www.instagram.com/janaananthakrishnan/"><i
                                                class='bx bxl-instagram-alt'></i></a></li>
                                    <li><a href="https://www.linkedin.com/in/ananthakrishnan-janardhanan/"><i
                                                class='bx bxl-linkedin'></i></a></li>
                                    <li><a href="https://x.com/Anantha80112802/">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
                                                <g fill="none">
                                                    <g clip-path="url(#primeTwitter0)">
                                                        <path fill="currentColor"
                                                            d="M11.025.656h2.147L8.482 6.03L14 13.344H9.68L6.294 8.909l-3.87 4.435H.275l5.016-5.75L0 .657h4.43L7.486 4.71zm-.755 11.4h1.19L3.78 1.877H2.504z" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="primeTwitter0">
                                                            <path fill="#fff" d="M0 0h14v14H0z" />
                                                        </clipPath>
                                                    </defs>
                                                </g>
                                            </svg>
                                        </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-4">
                        <div class="homeAbout">
                            <span class="tinyTitle">{{ isset($aboutContent['journey_section']) && $aboutContent['journey_section']->heading ? $aboutContent['journey_section']->heading : 'JOURNEY' }}</span>
                            <h2>{{ isset($aboutContent['journey_section']) && $aboutContent['journey_section']->subheading ? $aboutContent['journey_section']->subheading : 'Ananthakrishnan J' }}</h2>
                            <p>{{ isset($aboutContent['journey_section']) && $aboutContent['journey_section']->content ? $aboutContent['journey_section']->content : 'Mr. Ananth is a seasoned executive and strategic leader with over 25 years of distinguished experience in transport, logistics, and integrated facility management.' }}</p>
                            <img class="mb-0 signature" src="/img/site/ananth-signature.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="homeAbout aboutMargin">
                            <h3>{{ isset($aboutContent['executive_leadership']) && $aboutContent['executive_leadership']->heading ? $aboutContent['executive_leadership']->heading : 'Executive Leadership and Strategic Vision' }}</h3>
                            <p>{!! isset($aboutContent['executive_leadership']) && $aboutContent['executive_leadership']->content ? nl2br(e($aboutContent['executive_leadership']->content)) : 'Currently, Mr. Ananth leads Transport & Logistics operations in Saudi Arabia, overseeing a workforce exceeding 2,500 professionals and managing multi-million-dollar budgets. His leadership is grounded in aligning logistics strategies with broader organizational and national objectives, including Saudi Arabia’s Vision 2030.' !!}</p>
                        </div>
                        <div class="homeAbout aboutMargin">
                            <h3>{{ isset($aboutContent['expertise_section']) && $aboutContent['expertise_section']->heading ? $aboutContent['expertise_section']->heading : 'Proven Expertise Across Global Enterprises' }}</h3>
                            <p>{!! isset($aboutContent['expertise_section']) && $aboutContent['expertise_section']->content ? nl2br(e($aboutContent['expertise_section']->content)) : 'His professional journey spans leadership roles at globally recognized firms such as JLL India, CBRE, Capita India, Omega Healthcare, and Sutherland Global Services.' !!}</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="homeAbout aboutMargin">
                            <h3>{{ isset($aboutContent['innovation_section']) && $aboutContent['innovation_section']->heading ? $aboutContent['innovation_section']->heading : 'Innovation, Sustainability, and Continuous Improvement' }}</h3>
                            <p>{!! isset($aboutContent['innovation_section']) && $aboutContent['innovation_section']->content ? nl2br(e($aboutContent['innovation_section']->content)) : 'Mr. Ananth is deeply committed to leveraging technology and data-driven insights to build agile, efficient, and sustainable supply chains. His leadership philosophy emphasizes the integration of cutting-edge digital tools and green logistics practices to future-proof operations and reduce environmental impact.' !!}</p>

                        </div>
                        <div class="acedemicInfo aboutMargin">
                            @php
                                $credentialItems = [];
                                if (isset($aboutContent['academic_credentials']) && $aboutContent['academic_credentials']->content) {
                                    $content = $aboutContent['academic_credentials']->content;

                                    // Normalize line breaks to \n
                                    $content = str_replace(["\r\n", "\r"], "\n", $content);

                                    // Replace <br> tags with double newline
                                    $content = preg_replace('/<br\s*\/?>/i', "\n\n", $content);

                                    // Split by double newlines (blank lines)
                                    $groups = preg_split('/\n\s*\n/', $content);

                                    foreach ($groups as $group) {
                                        $group = trim($group);
                                        if (empty($group)) continue;

                                        $lines = array_values(array_filter(array_map('trim', explode("\n", $group))));

                                        if (count($lines) >= 1) {
                                            $credentialItems[] = [
                                                'label' => $lines[0] ?? '',
                                                'title' => $lines[1] ?? '',
                                                'subtitle' => $lines[2] ?? ''
                                            ];
                                        }
                                    }
                                }

                                // Use default if no items were created
                                if (empty($credentialItems)) {
                                    $credentialItems = [
                                        [
                                            'label' => 'Pursuing',
                                            'title' => 'Doctorate in Business Administration',
                                            'subtitle' => 'Rushford Business School, Switzerland'
                                        ],
                                        [
                                            'label' => "Bachelor's Degree",
                                            'title' => 'Business Administration',
                                            'subtitle' => 'University of Madras, India'
                                        ],
                                        [
                                            'label' => 'Other Expertise',
                                            'title' => 'Six Sigma Master Black Belt',
                                            'subtitle' => ''
                                        ]
                                    ];
                                }
                            @endphp
                            <div class="academicCard">
                                <h3>{{ isset($aboutContent['academic_credentials']) && $aboutContent['academic_credentials']->heading ? $aboutContent['academic_credentials']->heading : 'Academic Credentials' }}</h3>
                                <div class="timeline">
                                    @foreach($credentialItems as $credential)
                                        <div class="timeline-item">
                                            <div class="dot"></div>
                                            <div class="content">
                                                @if(!empty($credential['label']))<span class="label">{{ $credential['label'] }}</span>@endif
                                                @if(!empty($credential['title']))<h4>{{ $credential['title'] }}</h4>@endif
                                                @if(!empty($credential['subtitle']))<p>{{ $credential['subtitle'] }}</p>@endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="aboutBg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="myCommitment">
                                <h3>{!! isset($aboutContent['commitment_section']) && $aboutContent['commitment_section']->heading ? $aboutContent['commitment_section']->heading : '<span>Commitment</span> to the Industry' !!}</h3>
                                <p>{!! isset($aboutContent['commitment_section']) && $aboutContent['commitment_section']->content ? nl2br(e($aboutContent['commitment_section']->content)) : 'Ananth Decodes Logistics is a reflection of Mr. Ananth’s passion for demystifying logistics and supply chain management. Through this platform, he shares insights, best practices, and strategic guidance that empower businesses and professionals to navigate the evolving logistics landscape with confidence.' !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <img class="imgBorder" src="/img/site/brush-up.png" alt="">
            </div>
            @if($milestones->count() > 0)
            <section class="milestones-section">
                <div class="container">
                    <div class="timeline-container" id="timelineContainer">
                        <div class="timeline-header">
                            <h1 class="timeline-title">Our Journey in Milestones</h1>
                            <p class="timeline-subtitle">Key achievements that define our excellence in logistics</p>
                        </div>

                        <div class="timeline-content" id="timelineContent">
                            <div class="event-year" id="eventYear">{{ $milestones->first()->year }}</div>
                            <div class="event-company" id="eventCompany">{{ $milestones->first()->title }}</div>
                            <div class="event-description" id="eventDescription">{{ $milestones->first()->description ?? 'A significant milestone in our journey' }}</div>
                        </div>

                        <div class="slider-container">
                            <div class="slider-track" id="sliderTrack">
                                <div class="progress-fill" id="progressFill"></div>
                            </div>
                            <input type="range" min="0" max="{{ $milestones->count() - 1 }}" value="0" class="timeline-slider" id="timelineSlider" step="1" aria-label="Timeline slider" />
                            <div class="year-labels" id="yearLabels"></div>
                        </div>
                    </div>
                </div>

                <script>
                    const timelineData = @json($milestones->map(function($milestone) {
                        return [
                            'year' => $milestone->year,
                            'company' => $milestone->title,
                            'description' => $milestone->description ?? 'A significant milestone in our journey'
                        ];
                    })->values());
                </script>
            </section>
            @endif
        </div>

        <!--<div id="executive-committee" class="tab-content">-->
        <!--    <div class="container">-->
        <!--        <div class="row mb-4">-->
        <!--            @foreach ($members as $item)-->
        <!--                <div class="col-lg-4 col-md-5 col-sm-6 mb-4">-->
        <!--                    <div class="teamCard">-->
        <!--                        <img src="/img/site/{{ $item->image }}" alt="">-->
        <!--                        <div class="teamMeta">-->
        <!--                            <h3>{{ $item->name }}</h3>-->
        <!--                            <span>{{ $item->designation }}</span>-->
        <!--                            <ul class="cardSocial">-->
        <!--                                @isset($item->insta)-->
        <!--                                    <li><a target="_blank" href="{{ $item->insta }}"><i-->
        <!--                                                class="bx bxl-instagram-alt"></i></a></li>-->
        <!--                                @endisset-->
        <!--                                @isset($item->linkedin)-->
        <!--                                    <li><a target="_blank" href="{{ $item->linkedin }}"><i-->
        <!--                                                class="bx bxl-linkedin"></i></a></li>-->
        <!--                                @endisset-->
        <!--                                @isset($item->twitter)-->
        <!--                                    <li><a target="_blank" href="{{ $item->twitter }}">-->
        <!--                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">-->
        <!--                                                <g fill="none">-->
        <!--                                                    <g clip-path="url(#primeTwitter0)">-->
        <!--                                                        <path fill="currentColor"-->
        <!--                                                            d="M11.025.656h2.147L8.482 6.03L14 13.344H9.68L6.294 8.909l-3.87 4.435H.275l5.016-5.75L0 .657h4.43L7.486 4.71zm-.755 11.4h1.19L3.78 1.877H2.504z">-->
        <!--                                                        </path>-->
        <!--                                                    </g>-->
        <!--                                                    <defs>-->
        <!--                                                        <clipPath id="primeTwitter0">-->
        <!--                                                            <path fill="#fff" d="M0 0h14v14H0z"></path>-->
        <!--                                                        </clipPath>-->
        <!--                                                    </defs>-->
        <!--                                                </g>-->
        <!--                                            </svg>-->
        <!--                                        </a>-->
        <!--                                    </li>-->
        <!--                                @endisset-->
        <!--                            </ul>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            @endforeach-->
        <!--        </div>-->
        <!--        <div class="row">-->
        <!--            <div class="col-lg-8 m-auto">-->
        <!--                <div class="contactForm contactPageForm">-->
        <!--                    @if ($errors->any())-->
        <!--                        <div class="alert_message">-->
        <!--                            <ul class="mb-0">-->
        <!--                                @foreach ($errors->all() as $error)-->
        <!--                                    <li>{{ $error }}</li>-->
        <!--                                @endforeach-->
        <!--                            </ul>-->
        <!--                        </div>-->
        <!--                    @endif-->
        <!--                    @if (session()->has('message'))-->
        <!--                        <div class="success_message">-->
        <!--                            {{ session()->get('message') }}-->
        <!--                        </div>-->
        <!--                    @endif-->

        <!--                    <h3>Fill the form below to become a part of the community.</h3>-->
        <!--                    <form action="{{ route('saveContact') }}" method="POST" id="contactForm">-->
        <!--                        @csrf-->
                                <!-- Personal Details -->
        <!--                        <div class="row">-->
        <!--                            <div class="col-md-6">-->
        <!--                                <h4>Name*</h4>-->
        <!--                                <input type="text" name="name" placeholder="Name *"-->
        <!--                                    value="{{ old('name') }}" required>-->
        <!--                            </div>-->
        <!--                            <div class="col-md-6">-->
        <!--                                <h4>Email*</h4>-->
        <!--                                <input type="email" name="email" placeholder="Email *"-->
        <!--                                    value="{{ old('email') }}" required>-->
        <!--                            </div>-->
        <!--                            <div class="col-md-6">-->
        <!--                                <h4>Phone Number</h4>-->
        <!--                                <input type="number" name="phone" placeholder="Phone Number"-->
        <!--                                    value="{{ old('phone') }}" pattern="\d*">-->
        <!--                            </div>-->
        <!--                            <div class="col-md-6">-->
        <!--                                <h4>Organization/Company Name*</h4>-->
        <!--                                <input type="text" name="organization"-->
        <!--                                    placeholder="Organization/Company Name *" value="{{ old('organization') }}"-->
        <!--                                    required>-->
        <!--                            </div>-->
        <!--                        </div>-->

                                <!-- Job Title / Role -->
        <!--                        <h4>Job Title/Role</h4>-->
        <!--                        <select name="job_title" id="jobTitleSelect" required>-->
        <!--                            <option selected disabled value="">Select Job Title/Role</option>-->
        <!--                            <option value="CEO/Executive">CEO/Executive</option>-->
        <!--                            <option value="Manager/Director">Manager/Director</option>-->
        <!--                            <option value="Researcher/Scholar">Researcher/Scholar</option>-->
        <!--                            <option value="Consultant">Consultant</option>-->
        <!--                            <option value="Other">Other</option>-->
        <!--                        </select>-->
        <!--                        <input type="text" id="jobTitleOther" name="job_title_other"-->
        <!--                            placeholder="Enter Job Title/Role" style="display:none;">-->

                                <!-- Subject -->
        <!--                        <h4>Subject*</h4>-->
        <!--                        <select name="subject" id="subjectSelect" required>-->
        <!--                            <option selected disabled value="">Select Subject</option>-->
        <!--                            <option value="Engagement Preference">Engagement Preference</option>-->
        <!--                            <option value="Service Request">Service Request</option>-->
        <!--                            <option value="Collaboration Opportunity">Collaboration Opportunity</option>-->
        <!--                            <option value="Feedback/Suggestions">Feedback/Suggestions</option>-->
        <!--                            <option value="Other">Other</option>-->
        <!--                        </select>-->
        <!--                        <input type="text" id="subjectOther" name="subject_other" placeholder="Enter Subject"-->
        <!--                            style="display:none;">-->


                                <!-- Your Service Interest -->
        <!--                        <h4>Service Interest*</h4>-->
        <!--                        <select name="services[]" class="chosen-select" multiple required>-->
        <!--                            <option value="Corporate Governance & Compliance">Corporate Governance & Compliance-->
        <!--                            </option>-->
        <!--                            <option value="Strategic Advisory for Logistics">Strategic Advisory for Logistics-->
        <!--                            </option>-->
        <!--                            <option value="ESG & Sustainability">ESG & Sustainability</option>-->
        <!--                            <option value="Financial Oversight & Risk Management">Financial Oversight & Risk-->
        <!--                                Management-->
        <!--                            </option>-->
        <!--                            <option value="Technology & Automation">Technology & Automation</option>-->
        <!--                            <option value="Talent Development">Talent Development</option>-->
        <!--                            <option value="Stakeholder Protection">Stakeholder Protection</option>-->
        <!--                            <option value="Crisis Management">Crisis Management</option>-->
        <!--                            <option value="Cross-Border Expansion">Cross-Border Expansion</option>-->
        <!--                            <option value="Network Platform for Research Scholars">Network Platform for Research-->
        <!--                                Scholars</option>-->
        <!--                        </select>-->

                                <!-- Engagement Preference -->
        <!--                        <h4 class="allCheckbox">Engagement Preference</h4>-->
        <!--                        <div class="checkbox-group">-->
        <!--                            <label><input type="checkbox" name="engagement[]"-->
        <!--                                    value="Executive Thought Leadership">-->
        <!--                                Executive Thought Leadership</label>-->
        <!--                            <label><input type="checkbox" name="engagement[]" value="Advisory Panel Membership">-->
        <!--                                Advisory Panel Membership</label>-->
        <!--                            <label><input type="checkbox" name="engagement[]"-->
        <!--                                    value="Strategic Business Partnership">-->
        <!--                                Strategic Business Partnership</label>-->
        <!--                            <label><input type="checkbox" name="engagement[]" value="Event Invitations"> Event-->
        <!--                                Invitations</label>-->
        <!--                            <label><input type="checkbox" name="engagement[]" value="Newsletter Subscription">-->
        <!--                                Newsletter Subscription</label>-->
        <!--                        </div>-->

                                <!-- Message -->
        <!--                        <h4>Message</h4>-->
        <!--                        <textarea name="message"-->
        <!--                            placeholder="Type your message here (e.g., specific queries, project details, or areas of interest)..." required>{{ old('message') }}</textarea>-->

                                <!-- Submit Button -->
        <!--                        <button type="submit" class="siteBtn">Get in Touch</button>-->
        <!--                    </form>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
    </section>

@endsection

@section('scripts')
    <script src="{{ asset('js/milestone-animation.js') }}"></script>
@endsection
