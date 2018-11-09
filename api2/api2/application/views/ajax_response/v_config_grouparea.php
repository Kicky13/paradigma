
              <table class="table table-hover">
                <?php $x=1; foreach($this->list_config as $config): ?>
                <tr>
                  <td><?php echo $config->NM_COMPANY ?></td>
                  <td><?php echo $config->NM_PLANT ?></td>
                  <td><?php echo $config->NM_GROUPAREA ?></td>
                  <td> 
					  	<a type="button" class="btn btn-info btn-xs" href="<?php echo site_url("component_assignment/view/".$config->ID_PLANT."/".$config->ID_GROUPAREA) ?>"> VIEW </a>
						<?php if($this->PERM_WRITE): ?>
						<a type="button" class="btn btn-success btn-xs" href="<?php echo site_url("component_assignment/edit/".$config->ID_PLANT."/".$config->ID_GROUPAREA) ?>">ASSIGNMENT</a>
						<?php endif; ?>
                  </td>
                </tr>
                <?php endforeach; ?>
                <?php if(!count($this->list_config)): ?>
                <tr><td colspan=5><i>Nothing area was added in this plant.</i></td></tr>
                <?php endif; ?>
              </table>
