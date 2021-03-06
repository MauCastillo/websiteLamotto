from django.shortcuts import render
from django.core.paginator import Paginator, EmptyPage, PageNotAnInteger
from .models import  Client, Receiver
from django.shortcuts import redirect

from django.core.mail import send_mail
from django.conf import settings



# Create your views here.
def home(request):
    if request.method == 'GET':
        context = {'status': False}
        return render(request, 'index.html', context)

    elif request.method == 'POST':
        modelClient = Client()
        modelClient.name = request.POST.get('name')
        modelClient.last_name = request.POST.get('last_name')
        modelClient.phone_number = request.POST.get('phone_number')
        modelClient.email = request.POST.get('email')
        modelClient.placa = request.POST.get('placa')
        modelClient.cedula = request.POST.get('cedula')
        modelClient.save()
        sendEmail(modelClient.id)

        context = {'status': True, 'user': modelClient.id}
        return render(request, 'index.html', context)


# Create your views here.
def register(request):

    if request.user.is_anonymous:
        return redirect('home')

    # user is a real user
    user_list = Client.objects.all()
    page = request.GET.get('page', 1)

    paginator = Paginator(user_list, 10)
    try:
        users = paginator.page(page)
    except PageNotAnInteger:
        users = paginator.page(1)
    except EmptyPage:
        users = paginator.page(paginator.num_pages)

    return render(request, 'information.html', { 'users': users })


def sendEmail(clientId):
    receivers = Receiver.objects.values_list('email', flat=True)
    list_email = list(receivers)
    client = Client.objects.get(id=clientId)

    subject = 'N0: {client_id} Nueva Solicitud de Cliente {name}'.format(
        client_id=clientId,
        name=client.name
    )

    message = 'Nombre {name} \n'
    message += 'Apellido: {last_name} \n'
    message += 'Telefono: {phone_number} \n'
    message += 'Placa: {placa} \n'
    message += 'Cedula: {cedula} \n'

    body = message.format(
        name=client.name,
        last_name=client.last_name,
        phone_number=client.phone_number,
        model_date=client.model_date,
        placa=client.placa,
        cedula=client.cedula
    )

    email_from = settings.EMAIL_HOST_USER
    recipient_list = list(list_email)
    send_mail( subject, body, email_from, recipient_list )


def termino(request):

    return render(request, 'terms_and_conditions.html')