<section id="oa_appointments">
	<table>
		<thead>
			<tr>
				<th>Nombre del Cliente</th>
				<th>Correo del Cliente</th>
				<th>Fecha de la Cita</th>
				<th>Hora de la Cita</th>
				<th>Ubicacion del Cliente</th>
				<th>Tipo de servicio</th>
				<th>Nombre de Consulta</th>
				<th>Fecha en que realizó la cita</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($records as $i) : ?>
			<tr>
				<td><?php echo $i->post_title  ?></td>
				<td>Dos</td>
				<td>Tres</td>
				<td>
					<select id="post_<?php echo $i->ID ?>">
						<?php foreach ($types as $j) : ?>
						<option value="<?php echo $j['value'] ?>"
							<?php echo $j['value'] == 'publish' ? 'selected' : '' ?>><?php echo $j['label'] ?>
						</option>
						<?php endforeach; ?>
					</select>
				</td>
				<td>Cinco</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</section>