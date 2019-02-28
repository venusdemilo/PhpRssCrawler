<?php

namespace App\Controller;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
    * @Route("/forgottenPassword", name="app_forgotten_password")
    */
    public function forgottenPassword(
      Request $request,
      UserPasswordEncoderInterface $encoder,
      TokenGeneratorInterface $token,
      \Swift_Mailer $mailer
      ): Response{
      if ($request->isMethod('POST')) {
                  $email = $request->request->get('email');
                  $entityManager = $this->getDoctrine()->getManager();
                  $user = $entityManager->getRepository(User::class)->findOneByEmail($email);
                  /* @var $user User */
                  if ($user === null)
                  {
                      $this->addFlash('danger', 'Email Inconnu');
                      return $this->redirectToRoute('user_index');
                  }
                  // création du nouveau jeton
                  $token = $token->generateToken();
                  try{
                      $user->setToken($token); // remplacement de l'ancien jeton
                      $entityManager->flush();
                  } catch (\Exception $e) {
                      $this->addFlash('warning', $e->getMessage());
                      return $this->redirectToRoute('user_index');
                  }

                  $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

                  $message = (new \Swift_Message('Forgot Password'))
                      ->setFrom('philippe.lapeyrie@chu-nimes.fr')
                      ->setTo($user->getEmail())
                      ->setBody(
                          "blablabla voici le token pour reseter votre mot de passe : " . $url,
                          'text/html'
                      );

                  $mailer->send($message);

                  $this->addFlash('notice', 'Mail envoyé');

                  return $this->redirectToRoute('user_index');
          }
    return $this->render('security/forgotten_password.html.twig');
    }

    /**
     * @Route("/reset_password/{token}", name="app_reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {

        if ($request->isMethod('POST')) {
            $entityManager = $this->getDoctrine()->getManager();

            $user = $entityManager->getRepository(User::class)->findOneByToken($token);
            /* @var $user User */

            if ($user === null) {
                $this->addFlash('danger', 'Token Inconnu');
                return $this->redirectToRoute('user_index');
            }

            $user->setToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $entityManager->flush();

            $this->addFlash('notice', 'Mot de passe mis à jour');

            return $this->redirectToRoute('user_index');
        }else {

            return $this->render('security/reset_password.html.twig', ['token' => $token]);
        }

    }





    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
      // vide ! C'est juste ... pour la route
    }


}
