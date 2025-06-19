<?php
$bloqueado = "<div style=color:#c70a23>Desativado</div>";
?>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th scope="col">Nome</th>
            <th scope="col">Usuário</th>
            <th scope="col">E-mail</th>
            <th scope="col">Situação</th>
            <th scope="col">Tipo de Perfil</th>
            <th scope="col">Cadastramento</th>
            <th scope="col">Ultimo Acesso</th>
            <th scope="col">Bloquear Usuário</th>
            <th scope="col">Desbloquear Usuário</th>
            <th scope="col">Deletar Usuário</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($info as $info): ?>
            <tr>
                <th scope="row"><?php echo $info['tb_nome']; ?></th>
                <td><?php echo $info['tb_user']; ?></td>
                <td><?php echo $info['tb_email']; ?></td>
                <td style="text-align: center"><?php echo $info['tb_cod_situacao'] === 1 ? "Ativo" : "$bloqueado"; ?></td>
                <td style="text-align: center"><?php echo $info['tb_id_modalidade'] === 1 ? "Adm" : "Consulta"; ?></td>
                <td style="text-align: center"><?php echo date('d/m/Y', strtotime($info['tb_data_cadastro'])); ?></td>
                <td style="text-align: center"><?php echo date('d/m/Y H:i:s', strtotime($info['tb_data_registro'])); ?></td>
                <td style="text-align: center"><a href="<?php echo BASE_URL; ?>home/bloquearUser/<?php echo $info['tb_id']; ?>"> <img src="<?php echo BASE_URL; ?>assets/img/bloquear.png" width="30" height="30"></a> </td>
                <td style="text-align: center"><a href="<?php echo BASE_URL; ?>home/desbloquearUser/<?php echo $info['tb_id']; ?>"><img src="<?php echo BASE_URL; ?>assets/img/desbloquear.png" width="30" height="30"></a> </td>
                <td style="text-align: center"><a href="<?php echo BASE_URL; ?>home/deletarUser/<?php echo $info['tb_id']; ?>"><img src="<?php echo BASE_URL; ?>assets/img/delete.png" width="30" height="30"></a> </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>