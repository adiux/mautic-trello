<?php

// plugins/Idea2TrelloBundle/Controller/DefaultController.php

namespace MauticPlugin\Idea2TrelloBundle\Controller;

use Mautic\CoreBundle\Controller\FormController;

class DefaultController extends FormController
{
    /**
     * Display the world view.
     *
     * @param string $world
     *
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function worldAction($world = 'earth')
    {
        /* @var \MauticPlugin\HelloBundleBundle\Model\WorldModel $model */
        //$model = $this->getModel('helloworld.world');

        // Retrieve details about the world
        //$worldDetails = $model->getWorldDetails($world);

        return $this->delegateView(
            [
                'viewParameters'  => [
                    'world'   => $world,
                    //'details' => $worldDetails
                ],
                'contentTemplate' => 'Idea2TrelloBundle:World:index.html.php',
                'passthroughVars' => [
                    'activeLink'    => 'plugin_helloworld_world',
                    'route'         => $this->generateUrl('plugin_helloworld_world', ['world' => $world]),
                    'mauticContent' => 'helloWorldDetails',
                ],
            ]
        );
    }
    // /**
    //  * @return \Symfony\Component\HttpFoundation\JsonResponse
    //  */
    // public function addCardAction()
    // {
    //     $data  = ['html' => '', 'style' => ''];
    //     // $focus = $request->request->all();
    //     // $channelId = (int) $this->request->request->get('channelId');

    //     // if (isset($focus['focus'])) {
    //     //     $focusArray = InputHelper::_($focus['focus']);

    //     //     if (!empty($focusArray['style']) && !empty($focusArray['type'])) {
    //     //         /** @var \MauticPlugin\MauticFocusBundle\Model\FocusModel $model */
    //     //         $model            = $this->getModel('focus');
    //     //         $focusArray['id'] = 'preview';
    //     //         $data['html']     = $model->getContent($focusArray, true);
    //     //     }
    //     // }

    //     return $this->handleView($data);
    // }
    /*
     * Contact form
     *
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    // public function contactAction()
    // {
    //     // Create the form object
    //     $form = $this->get('form.factory')->create('helloworld_contact');
    //
    //     // Handle form submission if POST
    //     if ($this->request->getMethod() == 'POST') {
    //         $flashes = array();
    //
    //         // isFormCancelled() checks if the cancel button was clicked
    //         if ($cancelled = $this->isFormCancelled($form)) {
    //
    //             // isFormValid() will bind the request to the form object and validate the data
    //             if ($valid = $this->isFormValid($form)) {
    //
    //                 /** @var \MauticPlugin\HelloBundleBundle\Model\ContactModel $model */
    //                 $model = $this->getModel('helloworld.contact');
    //
    //                 // Send the email
    //                 $model->sendContactEmail($form->getData());
    //
    //                 // Set success flash message
    //                 $flashes[] = array(
    //                     'type'    => 'notice',
    //                     'msg'     => 'plugin.helloworld.notice.thank_you',
    //                     'msgVars' => array(
    //                         '%name%' => $form['name']->getData()
    //                     )
    //                 );
    //             }
    //         }
    //
    //         if ($cancelled || $valid) {
    //             // Redirect to /hello/world
    //
    //             return $this->postActionRedirect(
    //                 array(
    //                     'returnUrl'       => $this->generateUrl('plugin_helloworld_world'),
    //                     'contentTemplate' => 'Idea2TrelloBundle:Default:world',
    //                     'flashes'         => $flashes
    //                 )
    //             );
    //         } // Otherwise show the form again with validation error messages
    //     }
    //
    //     // Display the form
    //     return $this->delegateView(
    //         array(
    //             'viewParameters'  => array(
    //                 'form' => $form->createView()
    //             ),
    //             'contentTemplate' => 'Idea2TrelloBundle:Contact:form.html.php',
    //             'passthroughVars' => array(
    //                 'activeLink' => 'plugin_helloworld_contact',
    //                 'route'      => $this->generateUrl('plugin_helloworld_contact')
    //             )
    //         )
    //     );
    // }
}
