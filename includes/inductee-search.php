<?php 
	$s = isset( $_GET['k'] ) ? $_GET['k'] : '';
	$this_year = date( 'Y' );
	$sports = get_terms( array( 'taxonomy' => 'sport', 'hide_empty' => false ) );
	$roles = get_terms( array( 'taxonomy' => 'role', 'hide_empty' => false ) );
	$levels = get_terms( array( 'taxonomy' => 'level_played', 'hide_empty' => false ) );
	$state_inductee = isset( $_GET['_state'] ) ? $_GET['_state'] : null;
	$selected_sports = isset( $_GET['_sport'] ) ? $_GET['_sport'] : null;
	$selected_roles = isset( $_GET['_role'] ) ? $_GET['_role'] : null;
	$selected_levels = isset( $_GET['_level'] ) ? $_GET['_level'] : null;
	$advanced_active = $selected_roles || $selected_levels ? ' in' : '';
?>
<div id="inductee-search">
    <form method="get" action="/inductees/">
        <div class="inductee-search-wrap">
            <div class="simple-search">
                <div class="field-group">
                    <div class="input-group">
                        <input type="text" placeholder="search for an inductee" name="k" value="<?php echo $s; ?>">
                        <span class="input-group-btn">
                            <button type="submit">Search</button>
                        </span>
                    </div>
                </div>
                <div class="form-box clearfix">
                    <div class="field-box left-box top-box box-threefourths">
                        <label>Year</label>
                        <div id="yrRange"><span class="range-min">1986</span><span class="range-max"><?php echo $this_year; ?></span></div>
                        <input id="yrInput" type="hidden" value="" name="_yr">
                    </div>
					<div class="field-box right-box box-fourth">
                        <label>State</label>
						<div class="level-options">
							<?php $state_checked = $state_inductee ? ' checked' : ''; ?>
							<label class="checkbox-inline">
								<input type="checkbox" value="1" name="_state"<?php echo $state_checked; ?>> PA State Inductee
							</label>
						</div>
                    </div>
					<?php if ( $sports ) : ?>
                    <div class="field-box bottom-box box-full clearfix">
                        <label>Sport</label>
                        <div class="sport-options">
							<?php
								foreach ( $sports as $sport ) :
									$checked = in_array( $sport->slug, $selected_sports ) ? ' checked' : '';
									$image = get_field( 'sport_category_image', 'sport_' . $sport->term_id );
									$icon = str_replace( array( ' ', '&amp;' ), array( '-', 'and' ), $sport->name );
							?>
                            <label class="checkbox-inline" data-toggle="tooltip" title="<?php echo esc_html( $sport->name ); ?>">
                                <input type="checkbox" value="<?php echo esc_html( $sport->slug ); ?>" name="_sport[]"<?php echo $checked; ?>> <span class="eshf-sport-<?php echo $icon; ?>"></span>
                            </label>
							<?php endforeach; ?>
                        </div>
						<?php endif; ?>
                    </div>
                </div>
                <div class="text-right">
                    <a href="#advanced-search" class="search-toggle" data-toggle="collapse">Advanced Search</a>
                </div>
            </div>
            <div class="advanced-search collapse<?php echo $advanced_active; ?>" id="advanced-search">
                <div class="form-box clearfix">
					<?php if ( $roles ) : ?>
                    <div class="field-box left-box box-twothirds">
                        <label>Role</label>
                        <div class="role-options">
							<?php
								foreach ( $roles as $role ) :
									$checked = in_array( $role->slug, $selected_roles ) ? ' checked' : '';
							?>
                            <label class="checkbox-inline">
                                <input type="checkbox" value="<?php echo esc_html( $role->slug ); ?>" name="_role[]"<?php echo $checked; ?>> <?php echo esc_html( $role->name ); ?>
                            </label>
							<?php endforeach; ?>
                        </div>
                    </div>
					<?php endif; ?>
					<?php if ( $levels ) : ?>
                    <div class="field-box right-box box-third">
                        <label>Level Played</label>
                        <div class="level-options">
							<?php
								foreach ( $levels as $level ) :
									$checked = in_array( $level->slug, $selected_levels ) ? ' checked' : '';
							?>
                            <label class="checkbox-inline">
                                <input type="checkbox" value="<?php echo esc_html( $level->slug ); ?>" name="_level[]"<?php echo $checked; ?>> <?php echo esc_html( $level->name ); ?>
                            </label>
							<?php endforeach; ?>
                        </div>
                    </div>
					<?php endif; ?>
                </div>
            </div>
            <div class="form-actions clearfix">
                <button type="submit">Filter Inductees</button>
                <button type="reset"><i class="fa fa-refresh"></i> Reset</button>
            </div>
        </div>
    </form>
</div>