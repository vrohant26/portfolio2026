<?php
/**
 * Template Name: Case Study
 * Template Post Type: archive
 */

get_header();

// Get the meta fields
$small_desc = get_post_meta(get_the_ID(), '_cs_small_desc', true);
$client     = get_post_meta(get_the_ID(), '_cs_client', true);
$scope      = get_post_meta(get_the_ID(), '_cs_scope', true);
$timeline   = get_post_meta(get_the_ID(), '_cs_timeline', true);
$leads      = get_post_meta(get_the_ID(), '_cs_leads', true);

// Get repeater and text fields
$context_desc = get_post_meta(get_the_ID(), '_cs_context_desc', true);
$context_steps = get_post_meta(get_the_ID(), '_cs_context_steps', true);
$challenge_cards = get_post_meta(get_the_ID(), '_cs_challenge_cards', true);

$solution_desc = get_post_meta(get_the_ID(), '_cs_solution_desc', true);
$solution_images = get_post_meta(get_the_ID(), '_cs_solution_images', true);
$role_cards = get_post_meta(get_the_ID(), '_cs_role_cards', true);
$solution_callout = get_post_meta(get_the_ID(), '_cs_solution_callout', true);

$tech_highlights = get_post_meta(get_the_ID(), '_cs_tech_highlights', true);
$result_stats = get_post_meta(get_the_ID(), '_cs_result_stats', true);
$result_bullets = get_post_meta(get_the_ID(), '_cs_result_bullets', true);
?>

<section id="case-study-template" class="flex h-full p-sm direction-column justify-between" style="max-width: 1300px; margin: auto; padding-top: 150px; min-height: 100vh;">
    <div class="top flex gap-lg direction-column justify-end">
        <div class="flex direction-column gap-md">
            
            <!-- Case Study Tag -->
            <div class="fit-content flex align-center gap-xs" style="background-color: var(--light); padding: 0.25rem 0.75rem; border-radius: 50px;">
                <span class="fs-xs" style="color: var(--dark); font-weight: bold;">Case study</span>
            </div>

            <!-- Page Title -->
            <h1 class="fs-lg text-light m-0" style="max-width: 1000px; line-height: 1.1; margin-bottom: 1rem;"><?php the_title(); ?></h1>
            
            <!-- Small Description -->
            <?php if ($small_desc) : ?>
            <p class="fs-sm text-gray-500 m-0 anim-translate" style="max-width: 500px" >
                <?php echo nl2br(esc_html($small_desc)); ?>
            </p>
            <?php endif; ?>
            
            <!-- 4 Column Grid -->
            <div class="case-study-meta-grid mt-md anim-translate" style="margin-top: 2rem; padding-bottom: 1rem;">
                
                <?php if ($client) : ?>
                <div class="meta-col flex direction-column gap-xs">
                    <span class="fs-xs text-gray-500" style="text-transform: uppercase; letter-spacing: 1px;">Client</span>
                    <strong class="fs-xs text-light"><?php echo esc_html($client); ?></strong>
                </div>
                <?php endif; ?>

                <?php if ($scope) : ?>
                <div class="meta-col flex direction-column gap-xs">
                    <span class="fs-xs text-gray-500" style="text-transform: uppercase; letter-spacing: 1px;">Scope</span>
                    <strong class="fs-xs text-light"><?php echo esc_html($scope); ?></strong>
                </div>
                <?php endif; ?>

                <?php if ($timeline) : ?>
                <div class="meta-col flex direction-column gap-xs">
                    <span class="fs-xs text-gray-500" style="text-transform: uppercase; letter-spacing: 1px;">Timeline</span>
                    <strong class="fs-xs text-light"><?php echo esc_html($timeline); ?></strong>
                </div>
                <?php endif; ?>

                <?php if ($leads) : ?>
                <div class="meta-col flex direction-column gap-xs">
                    <span class="fs-xs text-gray-500" style="text-transform: uppercase; letter-spacing: 1px;">Leads / Month</span>
                    <strong class="fs-xs text-light"><?php echo esc_html($leads); ?></strong>
                </div>
                <?php endif; ?>

            </div>

        </div>
    </div>
    
    <?php if ($context_desc || !empty($context_steps)) : ?>
    <div class="case-study-context mt-xl" style="margin-top: 5rem;">
        <span class="fs-xs text-gray-500" style="text-transform: uppercase; letter-spacing: 1px; display: inline-block;">Context</span>
        
        <?php if ($context_desc) : ?>
        <p class="fs-md text-light" style="  margin-top: 1.5rem;">
            <?php echo nl2br(esc_html($context_desc)); ?>
        </p>
        <?php endif; ?>

        <!-- Steps -->
        <?php if (!empty($context_steps) && is_array($context_steps)) : ?>
        <div class="context-steps flex align-center justify-between mt-lg" style="overflow-x: auto; padding-bottom: 1rem; margin-top: 3rem;">
            <?php foreach ($context_steps as $i => $step) : ?>
                <div class="step-card anim-translate" style="
                    background-color: <?php echo $step['is_problem'] ? '#ffece0' : 'var(--gray-100)'; ?>;
                    border: 1px solid <?php echo $step['is_problem'] ? '#ffb999' : 'transparent'; ?>;
                    padding: 1.5rem 2rem;
                    border-radius: 12px;
                    min-width: 180px;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    text-align: center;
                ">
                    <span class="fs-xs" style="color: <?php echo $step['is_problem'] ? '#d35400' : 'var(--gray-500)'; ?>; margin-bottom: 0.5rem;"><?php echo esc_html($step['label']); ?></span>
                    <strong class="fs-sm" style="color: <?php echo $step['is_problem'] ? '#d35400' : 'var(--light)'; ?>;"><?php echo esc_html($step['title']); ?></strong>
                </div>
                
                <?php if ($i < count($context_steps) - 1) : ?>
                    <div class="step-arrow text-gray-500 anim-translate">→</div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($challenge_cards) && is_array($challenge_cards)) : ?>
    <hr class="anim-translate" style="border: none; border-top: 1px solid var(--gray-300); margin-top: 4rem; margin-bottom: 3rem;">
    <div class="case-study-challenge">
        <span class="fs-xs text-gray-500" style="text-transform: uppercase; letter-spacing: 1px; display: inline-block;">The Challenge</span>
        
        <div class="challenge-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-top: 2rem;">
            <?php foreach ($challenge_cards as $card) : ?>
                <div class="challenge-card flex align-center anim-translate" style="background-color: var(--gray-100); padding: 1.5rem; border-radius: 12px; gap: 1rem;">
                    <?php if ($card['icon']) : 
                        $icon_url = esc_url($card['icon']);
                        $ext = pathinfo(parse_url($icon_url, PHP_URL_PATH), PATHINFO_EXTENSION);
                        if (strtolower($ext) === 'svg') {
                            $attachment_id = attachment_url_to_postid($icon_url);
                            $svg_path = $attachment_id ? get_attached_file($attachment_id) : '';
                            if ($svg_path && file_exists($svg_path)) {
                                $svg_content = file_get_contents($svg_path);
                                // Inject style inline to force dimensions and fill
                                $svg_content = preg_replace('/<svg/', '<svg style="width: 24px; height: 24px; fill: var(--light); flex-shrink: 0;"', $svg_content, 1);
                                echo $svg_content;
                            } else {
                                echo '<img src="'.$icon_url.'" alt="" style="width: 24px; height: 24px; object-fit: contain; flex-shrink: 0;">';
                            }
                        } else {
                            echo '<img src="'.$icon_url.'" alt="" style="width: 24px; height: 24px; object-fit: contain; flex-shrink: 0;">';
                        }
                    endif; ?>
                    <strong class="fs-sm text-light"><?php echo esc_html($card['text']); ?></strong>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($solution_desc || !empty($solution_images) || !empty($role_cards)) : ?>
    <hr class="anim-translate" style="border: none; border-top: 1px solid var(--gray-300); margin-top: 4rem; margin-bottom: 3rem;">
    <div class="case-study-solution">
        <span class="fs-xs text-gray-500" style="text-transform: uppercase; letter-spacing: 1px; display: inline-block;">The Solution</span>
        
        <?php if ($solution_desc) : ?>
        <p class="fs-md text-light" style="max-width: 900px; line-height: 1.4; margin-top: 1.5rem; margin-bottom: 3rem;">
            <?php echo nl2br(esc_html($solution_desc)); ?>
        </p>
        <?php endif; ?>

        <?php if (!empty($solution_images) && is_array($solution_images)) : ?>
            <?php foreach ($solution_images as $img) : 
                $layout_type = isset($img['layout_type']) ? $img['layout_type'] : '1';
            ?>
                <div class="solution-image-container anim-translate" style="margin-bottom: 3rem;">
                    <?php if ($img['top_caption']) : ?>
                        <div class="image-caption flex align-center gap-xs" style="background-color: #ffece0; color: #d35400; padding: 0.4rem 1rem; border-radius: 8px; font-size: 0.8rem; width: fit-content; margin-bottom: -12px; position: relative; z-index: 2; margin-left: 1rem;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                            <?php echo esc_html($img['top_caption']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($layout_type == '2') : ?>
                        <!-- 2 Column Image Layout -->
                        <div class="solution-images-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                            <!-- Image 1 -->
                            <div>
                                <div class="image-wrapper" style="border: 1px dashed var(--gray-500); padding: 4rem 2rem; border-radius: 12px; display: flex; flex-direction: column; align-items: center; justify-content: center; background-color: transparent;">
                                    <?php if ($img['url']) : ?>
                                        <img src="<?php echo esc_url($img['url']); ?>" alt="" style="max-width: 100%; height: auto; border-radius: 8px;">
                                    <?php endif; ?>
                                </div>
                                <?php if ($img['bottom_caption']) : ?>
                                    <p class="fs-sm text-gray-500" style="text-align: center; margin-top: 1rem;">
                                        <?php echo esc_html($img['bottom_caption']); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Image 2 -->
                            <div>
                                <div class="image-wrapper" style="border: 1px dashed var(--gray-500); padding: 4rem 2rem; border-radius: 12px; display: flex; flex-direction: column; align-items: center; justify-content: center; background-color: transparent;">
                                    <?php if (!empty($img['url2'])) : ?>
                                        <img src="<?php echo esc_url($img['url2']); ?>" alt="" style="max-width: 100%; height: auto; border-radius: 8px;">
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($img['bottom_caption2'])) : ?>
                                    <p class="fs-sm text-gray-500" style="text-align: center; margin-top: 1rem;">
                                        <?php echo esc_html($img['bottom_caption2']); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <!-- 1 Column Image Layout -->
                        <div class="image-wrapper" style="border: 1px dashed var(--gray-500); padding: 4rem 2rem; border-radius: 12px; display: flex; flex-direction: column; align-items: center; justify-content: center; background-color: transparent;">
                            <?php if ($img['url']) : ?>
                                <img src="<?php echo esc_url($img['url']); ?>" alt="" style="max-width: 100%; height: auto; border-radius: 8px;">
                            <?php endif; ?>
                        </div>

                        <?php if ($img['bottom_caption']) : ?>
                            <p class="fs-sm text-gray-500" style="text-align: center; margin-top: 1rem;">
                                <?php echo esc_html($img['bottom_caption']); ?>
                            </p>
                        <?php endif; ?>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($role_cards) && is_array($role_cards)) : ?>
            <div class="role-cards-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-top: 3rem;">
                <?php foreach ($role_cards as $card) : ?>
                    <div class="role-card anim-translate" style="border: 1px solid var(--gray-300); border-radius: 16px; padding: 2rem; background-color: var(--gray-100);">
                        <?php if ($card['icon']) : ?>
                            <div class="role-icon" style="width: 48px; height: 48px; background-color: #e0f2fe; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                                <?php 
                                $icon_url = esc_url($card['icon']);
                                $ext = pathinfo(parse_url($icon_url, PHP_URL_PATH), PATHINFO_EXTENSION);
                                if (strtolower($ext) === 'svg') {
                                    $attachment_id = attachment_url_to_postid($icon_url);
                                    $svg_path = $attachment_id ? get_attached_file($attachment_id) : '';
                                    if ($svg_path && file_exists($svg_path)) {
                                        $svg_content = file_get_contents($svg_path);
                                        $svg_content = preg_replace('/<svg/', '<svg style="width: 20px; height: 20px; fill: #0369a1;"', $svg_content, 1);
                                        echo $svg_content;
                                    } else {
                                        echo '<img src="'.$icon_url.'" alt="" style="width: 20px; height: 20px; object-fit: contain;">';
                                    }
                                } else {
                                    echo '<img src="'.$icon_url.'" alt="" style="width: 20px; height: 20px; object-fit: contain;">';
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <strong class="fs-sm text-light" style="display: block; margin-bottom: 1rem;"><?php echo esc_html($card['title']); ?></strong>
                        
                        <?php if ($card['bullets']) : 
                            $lines = explode("\n", str_replace("\r", "", $card['bullets']));
                        ?>
                            <ul class="text-gray-500 fs-sm" style="list-style: none; padding-left: 0; margin: 0; display: flex; flex-direction: column; gap: 0.5rem;">
                                <?php foreach ($lines as $line) : 
                                    if (trim($line)) : ?>
                                    <li style="display: flex; gap: 0.5rem; align-items: flex-start;">
                                        <span style="color: var(--gray-500);">—</span> 
                                        <span><?php echo esc_html(trim($line)); ?></span>
                                    </li>
                                <?php endif; endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($solution_callout) : ?>
            <div class="solution-callout mt-lg anim-translate" style="background-color: #e6f6f1; border-left: 4px solid #10b981; padding: 1.5rem 2rem; border-radius: 0 8px 8px 0; margin-top: 4rem;">
                <p class="m-0 fs-sm" style="color: #047857; line-height: 1.5; font-weight: 500;">
                    <?php echo nl2br(esc_html($solution_callout)); ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    
    <?php if (!empty($tech_highlights) || !empty($result_stats) || $result_bullets) : ?>
    <hr class="anim-translate" style="border: none; border-top: 1px solid var(--gray-300); margin-top: 4rem; margin-bottom: 4rem;">
    <div class="case-study-results">
        
        <!-- Technical Highlights -->
        <?php if (!empty($tech_highlights) && is_array($tech_highlights)) : ?>
            <span class="fs-xs text-gray-500" style="text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 2rem;">Technical Highlights</span>
            <div class="tech-highlights-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 4rem;">
                <?php foreach ($tech_highlights as $highlight) : 
                    $icon_url = esc_url($highlight['icon']);
                ?>
                    <div class="tech-card flex align-center gap-sm anim-translate" style="background-color: var(--gray-100); padding: 1.5rem; border-radius: 12px;">
                        <?php if ($icon_url) : ?>
                            <div class="tech-icon" style="flex-shrink: 0; display: flex; align-items: center; justify-content: center; width: 24px; height: 24px;">
                                <?php 
                                $ext = pathinfo(parse_url($icon_url, PHP_URL_PATH), PATHINFO_EXTENSION);
                                if (strtolower($ext) === 'svg') {
                                    $attachment_id = attachment_url_to_postid($icon_url);
                                    if ($attachment_id) {
                                        $svg_path = get_attached_file($attachment_id);
                                        if ($svg_path && file_exists($svg_path)) {
                                            $svg_content = file_get_contents($svg_path);
                                            // Force fill color to theme light for these icons
                                            $svg_content = preg_replace('/<svg/', '<svg style="width: 20px; height: 20px; fill: var(--light); flex-shrink: 0;"', $svg_content, 1);
                                            echo $svg_content;
                                        } else {
                                            echo '<img src="'.$icon_url.'" alt="" style="width: 20px; height: 20px; object-fit: contain; filter: brightness(0) invert(1);">';
                                        }
                                    } else {
                                        echo '<img src="'.$icon_url.'" alt="" style="width: 20px; height: 20px; object-fit: contain; filter: brightness(0) invert(1);">';
                                    }
                                } else {
                                    echo '<img src="'.$icon_url.'" alt="" style="width: 20px; height: 20px; object-fit: contain; filter: brightness(0) invert(1);">';
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                        <strong class="fs-sm" style="line-height: 1.2; margin: 0; color: var(--light); font-weight: 500; text-transform: uppercase;"><?php echo esc_html($highlight['title']); ?></strong>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <hr style="border: 0; border-top: 1px solid var(--gray-300); margin-bottom: 4rem;">
        <?php endif; ?>

        <!-- Results Section -->
        <?php if (!empty($result_stats) || $result_bullets) : ?>
            <span class="fs-xs text-gray-500" style="text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 2rem;">Results</span>
            
            <?php if (!empty($result_stats) && is_array($result_stats)) : ?>
                <div class="result-stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
                    <?php foreach ($result_stats as $stat) : ?>
                        <div class="result-card anim-translate" style="background-color: var(--gray-100); padding: 2rem; border-radius: 12px;">
                            <strong style="display: block; font-size: 2.5rem; color: var(--light); line-height: 1; margin-bottom: 0.5rem;"><?php echo esc_html($stat['large_stat']); ?></strong>
                            <span class="fs-sm text-gray-500" style="display: block; line-height: 1.3; text-transform: uppercase; letter-spacing: 0.5px;"><?php echo esc_html($stat['subtitle']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($result_bullets) : 
                $lines = explode("\n", str_replace("\r", "", $result_bullets));
            ?>
                <ul class="result-bullets" style="list-style: none; padding-left: 0; margin: 0; display: flex; flex-direction: column; gap: 1rem;">
                    <?php foreach ($lines as $line) : 
                        if (trim($line)) : ?>
                        <li style="display: flex; gap: 1rem; align-items: flex-start; font-size: 1rem; font-weight: 500; color: var(--light);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 2px;">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <span style="line-height: 1.4;"><?php echo esc_html(trim($line)); ?></span>
                        </li>
                    <?php endif; endforeach; ?>
                </ul>
            <?php endif; ?>

        <?php endif; ?>
    </div>
    <?php endif; ?>
    

</section>

<?php
get_footer();
?>
