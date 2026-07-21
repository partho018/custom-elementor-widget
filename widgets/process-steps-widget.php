<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Utils;

class Custom_Process_Steps_Widget extends Widget_Base {

	public function get_name() {
		return 'custom_process_steps_widget';
	}

	public function get_title() {
		return esc_html__( 'Alternating Process Steps Timeline', 'custom-elementor-widgets' );
	}

	public function get_icon() {
		return 'eicon-flow';
	}

	public function get_categories() {
		return [ 'custom-elementor-category' ];
	}

	public function get_keywords() {
		return [ 'process', 'steps', 'timeline', 'alternating', 'cards', 'workflow', 'custom' ];
	}

	public function get_style_depends() {
		return [ 'custom-process-widget-style' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT TAB
		   ========================================================================== */

		// --- SECTION: PROCESS STEPS REPEATER ---
		$this->start_controls_section(
			'section_process_steps',
			[
				'label' => esc_html__( 'Process Steps List', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'step_number',
			[
				'label'       => esc_html__( 'Step Number', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '01.',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'step_title',
			[
				'label'       => esc_html__( 'Step Title', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Consultation & Assessment', 'custom-elementor-widgets' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'step_desc',
			[
				'label'   => esc_html__( 'Step Description', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'We assess your energy needs through consultation and site evaluation to design a customized solution.', 'custom-elementor-widgets' ),
				'rows'    => 4,
			]
		);

		$repeater->add_control(
			'step_image',
			[
				'label'   => esc_html__( 'Step Image', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'step_layout_override',
			[
				'label'   => esc_html__( 'Layout Override (Optional)', 'custom-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'auto'        => esc_html__( 'Auto Alternating', 'custom-elementor-widgets' ),
					'image_left'  => esc_html__( 'Image Left / Card Right', 'custom-elementor-widgets' ),
					'image_right' => esc_html__( 'Card Left / Image Right', 'custom-elementor-widgets' ),
				],
				'default' => 'auto',
			]
		);

		$this->add_control(
			'process_steps',
			[
				'label'       => esc_html__( 'Steps Repeater', 'custom-elementor-widgets' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'step_number' => '01.',
						'step_title'  => esc_html__( 'Consultation & Assessment', 'custom-elementor-widgets' ),
						'step_desc'   => esc_html__( 'We assess your energy needs through consultation and site evaluation to design a customized solution.', 'custom-elementor-widgets' ),
						'step_image'  => [ 'url' => Utils::get_placeholder_image_src() ],
					],
					[
						'step_number' => '02.',
						'step_title'  => esc_html__( 'System Design & Installation', 'custom-elementor-widgets' ),
						'step_desc'   => esc_html__( 'After assessment, we design and install a customized solar system for maximum efficiency.', 'custom-elementor-widgets' ),
						'step_image'  => [ 'url' => Utils::get_placeholder_image_src() ],
					],
					[
						'step_number' => '03.',
						'step_title'  => esc_html__( 'Maintenance & Monitoring', 'custom-elementor-widgets' ),
						'step_desc'   => esc_html__( 'We ensure continuous peak performance with regular inspections, repairs, and 24/7 system tracking.', 'custom-elementor-widgets' ),
						'step_image'  => [ 'url' => Utils::get_placeholder_image_src() ],
					],
				],
				'title_field' => '{{{ step_number }}} {{{ step_title }}}',
			]
		);

		$this->end_controls_section();


		// --- SECTION: TIMELINE CONNECTOR SETTINGS ---
		$this->start_controls_section(
			'section_connector_settings',
			[
				'label' => esc_html__( 'Timeline Connector Line Settings', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_connector',
			[
				'label'        => esc_html__( 'Show Connector Lines', 'custom-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'custom-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'custom-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_connector_arrow',
			[
				'label'        => esc_html__( 'Show Arrow Head Pointer', 'custom-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'custom-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'custom-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'show_connector' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		/* ==========================================================================
		   STYLE TAB
		   ========================================================================== */

		// --- STYLE: TEXT CONTENT CARDS ---
		$this->start_controls_section(
			'section_card_style',
			[
				'label' => esc_html__( 'Content Card Style', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_card_style' );

		// Card Normal Tab
		$this->start_controls_tab(
			'tab_card_normal',
			[ 'label' => esc_html__( 'Normal', 'custom-elementor-widgets' ) ]
		);

		$this->add_control(
			'card_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ce-process-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .ce-process-card',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .ce-process-card',
			]
		);

		$this->end_controls_tab();

		// Card Hover Tab
		$this->start_controls_tab(
			'tab_card_hover',
			[ 'label' => esc_html__( 'Hover', 'custom-elementor-widgets' ) ]
		);

		$this->add_control(
			'card_hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ce-process-card:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_hover_box_shadow',
				'selector' => '{{WRAPPER}} .ce-process-card:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_hover_border',
				'selector' => '{{WRAPPER}} .ce-process-card:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => esc_html__( 'Card Padding', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top' => '44', 'right' => '40', 'bottom' => '44', 'left' => '40', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-process-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-process-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// --- STYLE: STEP NUMBER ---
		$this->start_controls_section(
			'section_number_style',
			[
				'label' => esc_html__( 'Step Number Style', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'number_typography',
				'selector' => '{{WRAPPER}} .ce-process-number',
			]
		);

		$this->add_control(
			'number_color',
			[
				'label'     => esc_html__( 'Number Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff5500',
				'selectors' => [
					'{{WRAPPER}} .ce-process-number' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'number_margin_bottom',
			[
				'label'      => esc_html__( 'Margin Bottom', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-process-number' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// --- STYLE: STEP TITLE ---
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Step Title Style', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .ce-process-title',
			]
		);

		$this->start_controls_tabs( 'tabs_title_style' );

		$this->start_controls_tab(
			'tab_title_normal',
			[ 'label' => esc_html__( 'Normal', 'custom-elementor-widgets' ) ]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .ce-process-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_title_hover',
			[ 'label' => esc_html__( 'Hover', 'custom-elementor-widgets' ) ]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label'     => esc_html__( 'Hover Title Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff5500',
				'selectors' => [
					'{{WRAPPER}} .ce-process-card:hover .ce-process-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'title_margin_bottom',
			[
				'label'      => esc_html__( 'Margin Bottom', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-process-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();


		// --- STYLE: STEP DESCRIPTION ---
		$this->start_controls_section(
			'section_desc_style',
			[
				'label' => esc_html__( 'Step Description Style', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .ce-process-desc',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .ce-process-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// --- STYLE: STEP IMAGE BOX ---
		$this->start_controls_section(
			'section_image_style',
			[
				'label' => esc_html__( 'Step Image Box & Column Width Style', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_col_width',
			[
				'label'      => esc_html__( 'Image Column Width (%)', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [ '%' => [ 'min' => 20, 'max' => 50 ] ],
				'default'    => [ 'unit' => '%', 'size' => 40 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-process-col-image' => 'flex: 0 0 {{SIZE}}%; max-width: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'card_col_width',
			[
				'label'      => esc_html__( 'Card Column Width (%)', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [ '%' => [ 'min' => 45, 'max' => 75 ] ],
				'default'    => [ 'unit' => '%', 'size' => 56 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-process-col-card' => 'flex: 0 0 {{SIZE}}%; max-width: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label'      => esc_html__( 'Image Box Height', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 180, 'max' => 600 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 340 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-process-image-wrap' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .ce-process-image-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'image_box_shadow',
				'selector' => '{{WRAPPER}} .ce-process-image-wrap',
			]
		);

		$this->end_controls_section();


		// --- STYLE: TIMELINE CONNECTOR LINE & SPACING ---
		$this->start_controls_section(
			'section_connector_style',
			[
				'label' => esc_html__( 'Timeline Line & Row Spacing', 'custom-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'      => esc_html__( 'Vertical Gap Between Steps', 'custom-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 20, 'max' => 140 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 60 ],
				'selectors'  => [
					'{{WRAPPER}} .ce-process-steps-list' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'connector_color',
			[
				'label'     => esc_html__( 'Connector Line Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#334155',
				'selectors' => [
					'{{WRAPPER}} .ce-process-connector-path' => 'stroke: {{VALUE}};',
				],
				'condition' => [
					'show_connector' => 'yes',
				],
			]
		);

		$this->add_control(
			'connector_arrow_color',
			[
				'label'     => esc_html__( 'Connector Arrow Color', 'custom-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff5500',
				'selectors' => [
					'{{WRAPPER}} .ce-process-arrow-head' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'show_connector' => 'yes',
					'show_connector_arrow' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['process_steps'] ) ) {
			return;
		}

		$total_steps    = count( $settings['process_steps'] );
		$show_connector = ( 'yes' === $settings['show_connector'] );
		$show_arrow     = ( 'yes' === $settings['show_connector_arrow'] );
		?>

		<div class="ce-process-steps-section">
			<div class="ce-process-steps-list">

				<?php foreach ( $settings['process_steps'] as $index => $step ) :
					$override_dir = ! empty( $step['step_layout_override'] ) ? $step['step_layout_override'] : 'auto';
					
					// Determine alternating direction: Even index (0, 2...) = Image Left, Odd index (1, 3...) = Image Right
					if ( 'auto' === $override_dir ) {
						$row_class = ( 0 === $index % 2 ) ? 'ce-layout-image-left' : 'ce-layout-image-right';
					} elseif ( 'image_left' === $override_dir ) {
						$row_class = 'ce-layout-image-left';
					} else {
						$row_class = 'ce-layout-image-right';
					}

					$img_src = ! empty( $step['step_image']['url'] ) ? $step['step_image']['url'] : Utils::get_placeholder_image_src();

					$step_title_setting_key = $this->get_repeater_setting_key( 'step_title', 'process_steps', $index );
					$this->add_inline_editing_attributes( $step_title_setting_key, 'none' );
				?>

					<div class="ce-process-step-row <?php echo esc_attr( $row_class ); ?>">

						<!-- Image Column -->
						<div class="ce-process-col-image">
							<div class="ce-process-image-wrap">
								<img src="<?php echo esc_url( $img_src ); ?>" alt="<?php echo esc_attr( $step['step_title'] ); ?>" class="ce-process-img" />
							</div>
						</div>

						<!-- Card Column -->
						<div class="ce-process-col-card">
							<div class="ce-process-card">

								<?php if ( ! empty( $step['step_number'] ) ) : ?>
									<span class="ce-process-number">
										<?php echo esc_html( $step['step_number'] ); ?>
									</span>
								<?php endif; ?>

								<?php if ( ! empty( $step['step_title'] ) ) : ?>
									<h3 class="ce-process-title" <?php echo $this->get_render_attribute_string( $step_title_setting_key ); ?>>
										<?php echo esc_html( $step['step_title'] ); ?>
									</h3>
								<?php endif; ?>

								<?php if ( ! empty( $step['step_desc'] ) ) : ?>
									<p class="ce-process-desc">
										<?php echo esc_html( $step['step_desc'] ); ?>
									</p>
								<?php endif; ?>

							</div>
						</div>

						<!-- Curved Connector SVG Line for between steps -->
						<?php if ( $show_connector && $index < ( $total_steps - 1 ) ) : 
							$is_left_to_right = ( 'ce-layout-image-left' === $row_class );
						?>
							<div class="ce-process-connector">
								<svg class="ce-process-connector-svg" viewBox="0 0 500 50" preserveAspectRatio="none">
									<?php if ( $is_left_to_right ) : ?>
										<!-- Curve connecting from Left Image/Card down towards Right -->
										<path class="ce-process-connector-path" d="M 50,0 Q 250,50 450,50" />
										<?php if ( $show_arrow ) : ?>
											<polygon class="ce-process-arrow-head" points="250,25 240,18 242,32" transform="rotate(5, 250, 25)" />
										<?php endif; ?>
									<?php else : ?>
										<!-- Curve connecting from Right down towards Left -->
										<path class="ce-process-connector-path" d="M 450,0 Q 250,50 50,50" />
										<?php if ( $show_arrow ) : ?>
											<polygon class="ce-process-arrow-head" points="250,25 260,18 258,32" transform="rotate(-5, 250, 25)" />
										<?php endif; ?>
									<?php endif; ?>
								</svg>
							</div>
						<?php endif; ?>

					</div>

				<?php endforeach; ?>

			</div>
		</div>

		<?php
	}
}
