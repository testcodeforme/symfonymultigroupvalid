
Project created in Symfony 4.1.6 to test possible bug with use multiple groups in constraint <code>Valid</code> using the component Forms.

<strong>Considerations</strong>

1) Sorry for me bad English.
2) Ignore business logic (I used basic logic to simplify i want do it)
3) I can resolve it with other options (Using a unique group), but do not usign constraint form <code>Valid</code> with multiple grpuos.

<strong>Before starting</strong>

1) You need load initial data:
<code>
INSERT INTO `country` (`id`, `name`, `iso`, `estatus`) VALUES (1, 'Brazil', 'BR', 1), (2, 'Venezuela', 'VE', 1), (3, 'Mexico', 'MX', 2);
</code>

Sorry for dont use Migrations :/

<strong>How solumate "Bug"</strong>

To simulate "Bug" you need go to route: http://localhost:8001/new
 
1) Select all checkbox for active validation by Item
2) Select Country "Mexico" in two Items and another Country in the rest
3) Submit Form.

<strong>Problem/Bug</strong>

We have next relation. 
Enity Cart 1 -> M with Item, and a Item have a Country.

Cart Form (CartNewType) have a CollectionType of another Form (ItemNewType)

<code>$builder->add('items', CollectionType::class, [
    'required' => false,
    'entry_type' => ItemNewType::class,
    'by_reference' => false,
    'entry_options' => [
        'constraints' => [new Assert\Valid(
            ['groups' => 
                [
                    'InformationExtra',
                    'CountryValid',
                    'Information',
                ]
            ]
        )],
    ]
])</code>


Entity Country have the next constraint in attribute $status:

 <code>@Assert\Choice({1}, groups={"CountryValid"})</code>
 If Country is Status 2 ("Mexico") launch a Form Violation
 
 And to resolve groups

<code>public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults([
        'data_class' => Item::class,
        'validation_groups' => function (FormInterface $form) {
            $useItem = $form->get('useItem')->getData();
            $groups = [];
            if (true == $useItem) {
                $groups[] = 'InformationExtra';
                $groups[] = 'CountryValid';
                $groups[] = 'Information';
            }
            return $groups;
        }
    ]);
}
</code>

<strong>Case 1</strong>

If in form <code>CartNewType > items > Constraint Valid > groups</code> i use group "InformationExtra" (<code>['Information','InformationExtra','CountryValid']</code>) and set like INDEX 0 "InformationExtra" (<code>['InformationExtra','Information','CountryValid']</code>) in <code>ItemNewType > function configureOptions > validation_groups</code> dont working others groups (<b>"Information" and "CountryValid"</b>) but if set "InformationExtra" like INDEX 1+ work "InformationExtra" and the next Group set...

Maybe the problem is produced per using a group to Attribute not Mapped ("informationExtra") in Constraint Valid.

<strong>Case 2</strong>

If in form <code>CartNewType > items > Constraint Valid > groups</code> i delete group "InformationExtra" (<code>['Information','CountryValid']</code>)
only work the first group set in <code>ItemNewType > function configureOptions > validation_groups</code> to a mapped attribute.

<b>Work 'InformationExtra' and 'CountryValid'... But only valid the FIRST Item in Collection (Dont trhow Form Violation if another item Select "Mexico")... to:</b>

<code>$groups['InformationExtra', 'CountryValid', 'Information'];</code>  or <code>$groups['CountryValid', 'Information', 'InformationExtra'];</code> 

<b>Work 'InformationExtra' and 'Information'... to:</b>

<code>$groups['InformationExtra', 'Information', 'CountryValid'];</code> or <code>$groups['Information', 'CountryValid', 'InformationExtra'];</code>

<strong>How can use multiple groups in Form Contraint Valid and use the OptionsResolver to decide what groups use finaly?</strong>
