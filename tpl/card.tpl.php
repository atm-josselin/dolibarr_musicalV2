<!-- Un début de <div> existe de par la fonction dol_fiche_head() -->
	<input type="hidden" name="action" value="[view.action]" />
	<table width="100%" class="border">
		<tbody>
            <tr class="fieldrequired">
                <td width="25%">[langs.transnoentities(Label)]</td>
                <td>[view.showLabel;strconv=no]</td>
            </tr>

            <tr class="ref fieldrequired">
                <td width="25%">[langs.transnoentities(Ref)]</td>
                <td>[view.showRef;strconv=no]</td>
            </tr>

            <tr class="serial">
                <td width="25%">[langs.transnoentities(Serial)]</td>
                <td>[view.showSerial;strconv=no]</td>
            </tr>

            <tr class="product">
            [onshow;block=begin;when [view.mode]!='edit']
                [onshow;block=begin;when [object.fk_product]+-0]
                    <td width="25%">[langs.transnoentities(Product)]</td>
                [onshow; block=end]
            [onshow; block=end]
                <td>[view.showProduct;strconv=no]</td>
            </tr>


            <tr class="price">
                <td width="25%">[langs.transnoentities(Price)]</td>
                <td>[view.showPrice;strconv=no]</td>
            </tr>

            <tr class="category">
                <td width="25%">[langs.transnoentities(Category)]</td>
                <td>[view.showCategory;strconv=no]</td>
            </tr>

		</tbody>
	</table>

</div> <!-- Fin div de la fonction dol_fiche_head() -->

[onshow;block=begin;when [view.mode]='edit']
<div class="center">
	
	<!-- '+-' est l'équivalent d'un signe '>' (TBS oblige) -->
	[onshow;block=begin;when [object.id]+-0]
	<input type='hidden' name='id' value='[object.id]' />
	<input type="submit" value="[langs.transnoentities(Save)]" class="button" />
	[onshow;block=end]
	
	[onshow;block=begin;when [object.id]=0]
	<input type="submit" value="[langs.transnoentities(Create)]" class="button" />
	[onshow;block=end]
	
	<input type="button" onclick="javascript:history.go(-1)" value="[langs.transnoentities(Cancel)]" class="button">
	
</div>
[onshow;block=end]

[onshow;block=begin;when [view.mode]!='edit']
<div class="tabsAction">
	[onshow;block=begin;when [user.rights.musicalv2.write;noerr]=1]

    <div class="inline-block divButAction"><a href="[view.urlcard]?id=[object.id]&action=edit" class="butAction">[langs.transnoentities(Modify)]</a></div>
    <div class="inline-block divButAction"><a href="[view.urlcard]?id=[object.id]&action=delete" class="butActionDelete">[langs.transnoentities(Delete)]</a></div>
		
	[onshow;block=end]
</div>
[onshow;block=end]