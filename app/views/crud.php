<input type="hidden" id="entity" value="<?=$entity?>">
<input type="hidden" id="attributs" value="<?= htmlentities(json_encode($attributs, true)) ?>">

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-10">
                <h1 class="m-0 text-dark">
                    <?= $titrePage; ?>
                    <div class="" id=""></div>
                </h1>
            </div>
            <div class="col-sm-2" id="addBtnField">
                <button class="btn btn-primary btn-sm btn-block addBtn" data-toggle="tooltip" data-placement="bottom" title="Ajout d'un élément"><i class="fas fa-plus mr-2" aria-hidden="true"></i> Ajouter</button>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card table-responsive">
                    <div class="card-body">
                        <style>
                            td {
                                white-space: nowrap;
                            }
                        </style>
                        <table id="datatable" class="table table-bordered table-striped table-sm text-sm">
                            <thead>
                                <tr>
                                    <?php foreach ($attributs as $attribut): ?>
                                        <?php if(!$attribut['fillable'] || ($attribut['fillable'] && $attribut['input_type'] != 'password')): ?>
                                            <?php if(isset($attribut['foreign_key']) && $attribut['foreign_key']): ?>
                                                <th hidden scope="col"><?= $attribut['lib'] ?></th>
                                                <th scope="col"><?= $attribut['lib'] ?></th>
                                            <?php else: ?>
                                                <th scope="col"><?= $attribut['lib'] ?></th>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
	                                <th scope="col">Actions</th>
	                            </tr>
	                        </thead>
                            <tbody>
	                        </tbody>
                            <tfoot>
                                <tr>
                                    <?php foreach ($attributs as $attribut): ?>
                                        <?php if(!$attribut['fillable'] || ($attribut['fillable'] && $attribut['input_type'] != 'password')): ?>
                                            <?php if(isset($attribut['foreign_key']) && $attribut['foreign_key']): ?>
                                                <th hidden scope="col"><?= $attribut['lib'] ?></th>
                                                <th scope="col"><?= $attribut['lib'] ?></th>
                                            <?php else: ?>
                                                <th scope="col"><?= $attribut['lib'] ?></th>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
	                                <th scope="col">Actions</th>
	                            </tr>
	                        </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

<?php
function generateSelectOptions($filtered_class, $filtered_name) {
    $attributes = $filtered_class::attributs();
    foreach ($attributes as $attribute): ?>
        <?php if(isset($attribute['foreign_key']) && $attribute['foreign_key'] == true && $attribute['name'] != "annee_ID"): ?>

            <?php generateSelectOptions($attribute['ref_class'], $attribute['name']); ?>

            <div class="form-group">
                <label for="<?= $attribut['name'] ?>"><?= $attribute['lib'] ?></label>
                <?php
                    if(in_array('annee_ID', (new $attribute['ref_class'])->fillable()))
                        $elements = $attribute['ref_class']::whereAll([["annee_ID", "=", Annee::active()->getId()]]);
                    else
                        $elements = $attribute['ref_class']::all();
                ?>
                <select class="form-control select2 custom-select filter_class" id="<?= $attribute['name'] ?>" <?= $attribute['required'] ?> data-foreign-key="<?= $attribute['name'] ?>" data-filtered-class="<?= $filtered_class ?>" data-filtered-name="<?= $filtered_name ?>">
                    <option value=""></option>
                    <?php foreach($elements as $value): ?>
                        <option value="<?= $value->getId() ?>"><?= $value->getCode() ? $value->getCode() : $value->getLibelle() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; 
    endforeach;
}
?>

<!-- addModal -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-md ">
        <div class="modal-content">            
            
            <div class="modal-header bg-light">
                <h4 class="modal-title">Formulaire d'ajout</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span style="color: black;" aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                
                <?php foreach ($attributs as $attribut): ?>
                    <div class="form-group">
                        <?php if($attribut['fillable']): ?>
                            <?php if($attribut['input_type'] == "text"): ?>
                                <?php if(isset($attribut['hidden']) && $attribut['hidden'] == true): ?>
                                    <div class="form-group d-none">
                                        <label for="<?= $attribut['name'] ?>"><?= $attribut['lib'] ?></label>
                                        <input hidden type="text" class="form-control" id="<?= $attribut['name'] ?>" value="<?= $attribut['default'] ?>" <?= $attribut['required'] ?> />
                                    </div>
                                <?php else: ?>
                                    <div class="form-group">
                                        <label for="<?= $attribut['name'] ?>"><?= $attribut['lib'] ?></label>
                                        <input type="text" class="form-control" id="<?= $attribut['name'] ?>" <?= $attribut['required'] ?> />
                                    </div>
                                <?php endif; ?>
                            <?php elseif($attribut['input_type'] == "textarea"): ?>
                            <div class="form-group">
                                <label for="<?= $attribut['name'] ?>"><?= $attribut['lib'] ?></label>
                                <textarea id="<?= $attribut['name'] ?>" cols="30" rows="3" class="form-control" <?= $attribut['required'] ?>></textarea>
                            </div>
                            <?php elseif($attribut['input_type'] == "number"): ?>
                            <div class="form-group">
                                <label for="<?= $attribut['name'] ?>"><?= $attribut['lib'] ?></label>
                                <input type="number" class="form-control" id="<?= $attribut['name'] ?>" <?= $attribut['required'] ?> />
                            </div>
                            <?php elseif($attribut['input_type'] == "file"): ?>
                            <div class="form-group">
                                <label for="<?= $attribut['name'] ?>"><?= $attribut['lib'] ?></label>
                                <input type="file" class="form-control" id="<?= $attribut['name'] ?>" <?= $attribut['required'] ?> />
                            </div>
                            <?php elseif($attribut['input_type'] == "date"): ?>
                            <div class="form-group">
                                <label for="<?= $attribut['name'] ?>"><?= $attribut['lib'] ?></label>
                                <input type="date" class="form-control" id="<?= $attribut['name'] ?>" <?= $attribut['required'] ?> />
                            </div>
                            <?php elseif($attribut['input_type'] == "password"): ?>
                            <div class="form-group">
                                <label for="<?= $attribut['name'] ?>"><?= $attribut['lib'] ?></label>
                                <input type="password" class="form-control" id="<?= $attribut['name'] ?>" <?= $attribut['required'] ?> />
                            </div>
                            <?php elseif($attribut['input_type'] == "select"): ?>
                                <?php if(isset($attribut['foreign_key']) && $attribut['foreign_key'] == true): ?>

                                    <?php generateSelectOptions($attribut['ref_class'], $attribut['name']); ?>

                                    <?php
                                        $elements = $attribut['ref_class']::all();
                                    ?>

                                    <!-- les parents consécutifs antérieurs -->
                                    <div class="form-group">
                                        <label for="<?= $attribut['name'] ?>"><?= $attribut['lib'] ?></label>
                                        <select class="form-control select2 custom-select" id="<?= $attribut['name'] ?>" <?= $attribut['required'] ?>>
                                            <option value=""></option>
                                            <?php foreach($elements as $value): ?>
                                                <option value="<?= $value->getId() ?>"><?= $value->getCode() ? $value->getCode() : $value->getNom() ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- le foreign key -->
                                <?php else: ?>
                                    <div class="form-group">
                                        <label for="<?= $attribut['name'] ?>"><?= $attribut['lib'] ?></label>
                                        <select class="form-control select2 custom-select" id="<?= $attribut['name'] ?>" <?= $attribut['required'] ?>>
                                            <option value=""></option>
                                            <?php foreach($attribut['input_values'] as$lib): ?>
                                                <option value="<?= $lib ?>"><?= $lib ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                            <?php elseif($attribut['input_type'] == "checkbox"): ?>
                            <div class="form-group">
                                <label for="<?= $attribut['name'] ?>"><?= $attribut['lib'] ?></label>
                                <input type="checkbox" id="<?= $attribut['name'] ?>">
                            </div>
                            <?php elseif($attribut['input_type'] == "radio"): ?>
                            <div class="form-group">
                                <label for="<?= $attribut['name'] ?>"><?= $attribut['lib'] ?></label>
                                <input type="radio" id="">
                            </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <th scope="col"></th>
                <?php endforeach; ?>
                
            </div>

            <div class="modal-footer justify-content-between">
                <div class="row w-100">
                    <div class="col-sm-6">
                        <button id="addBtn" class="btn btn-block btn-outline-primary">Créer</button>
                    </div>
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-block btn-outline-secondary" data-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- deleteModal -->
<div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title">Suppression</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mt-3">
                <div class="container">
                    <p>Voulez vous procéder à la suppression de cet élément ?</p>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <button id="deleteBtn" type="button" class="btn btn-block btn-outline-danger" data-dismiss="modal">Oui</button>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-block btn-outline-secondary" data-dismiss="modal">Non</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="<?= SCRIPTS ?>crud.js"></script>